<!DOCTYPE html>
<html>
<head>
    <title>Debug Permissions</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1a1a1a; color: #0f0; }
        pre { background: #000; padding: 15px; border: 1px solid #0f0; border-radius: 5px; overflow: auto; }
        h2 { color: #0ff; }
        .section { margin: 20px 0; }
        .error { color: #f00; }
        .success { color: #0f0; }
        .warning { color: #ff0; }
    </style>
</head>
<body>
    <h1>🔍 Permission Debug Page</h1>

    <div class="section">
        <h2>1. Session Data</h2>
        <pre>{{ json_encode([
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'admin_role_id' => session('admin_role_id'),
            'admin_role_name' => session('admin_role_name'),
            'permissions_count' => count(session('admin_permissions', [])),
        ], JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>2. Permissions Detail</h2>
        <pre>{{ json_encode(session('admin_permissions', []), JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>3. LocalStorage Check</h2>
        <div id="localStorageCheck"></div>
        <script>
            const adminAuth = localStorage.getItem('admin_auth');
            const container = document.getElementById('localStorageCheck');
            
            if (adminAuth) {
                const data = JSON.parse(adminAuth);
                container.innerHTML = '<pre class="success">✅ LocalStorage Data Found:\n' + JSON.stringify(data, null, 2) + '</pre>';
            } else {
                container.innerHTML = '<pre class="error">❌ No data in localStorage</pre>';
            }
        </script>
    </div>

    <div class="section">
        <h2>4. Helper Functions Test</h2>
        <div id="helperTest"></div>
        <script>
            const results = [];
            
            // Test getAllowedMenus
            if (typeof window.getAllowedMenus === 'function') {
                const menus = window.getAllowedMenus();
                results.push('✅ getAllowedMenus: ' + menus.length + ' menus found');
                results.push('   Menus: ' + JSON.stringify(menus.map(m => m.menu_name), null, 2));
            } else {
                results.push('❌ getAllowedMenus function not found');
            }
            
            // Test buildMenuTree
            if (typeof window.buildMenuTree === 'function') {
                const menus = window.getAllowedMenus ? window.getAllowedMenus() : [];
                const tree = window.buildMenuTree(menus);
                results.push('✅ buildMenuTree: ' + tree.length + ' root menus');
                results.push('   Tree: ' + JSON.stringify(tree.map(m => ({name: m.menu_name, children: m.children?.length || 0})), null, 2));
            } else {
                results.push('❌ buildMenuTree function not found');
            }
            
            // Test hasPermission
            if (typeof window.hasPermission === 'function') {
                // Test with menu ID 1 (dashboard)
                const hasAccess = window.hasPermission(1, 'access');
                results.push('✅ hasPermission: Dashboard access = ' + hasAccess);
            } else {
                results.push('❌ hasPermission function not found');
            }
            
            document.getElementById('helperTest').innerHTML = '<pre class="success">' + results.join('\n') + '</pre>';
        </script>
    </div>

    <div class="section">
        <h2>5. Database Check (Backend)</h2>
        @php
            $menuCount = DB::table('admin_menus')->count();
            $permissionCount = DB::table('admin_permissions')->count();
            $menuPermissionCount = DB::table('admin_menu_permission')->count();
            $roleId = session('admin_role_id');
            $roleMenuPermissionCount = 0;
            
            if ($roleId) {
                $roleMenuPermissionCount = DB::table('admin_role_menu_permission')
                    ->where('role_id', $roleId)
                    ->where('allow', true)
                    ->count();
            }
        @endphp
        <pre class="success">✅ Database Counts:
  - Total Menus: {{ $menuCount }}
  - Total Permissions: {{ $permissionCount }}
  - Total Menu-Permission Mappings: {{ $menuPermissionCount }}
  - Your Role Permissions (allow=1): {{ $roleMenuPermissionCount }}</pre>
    </div>

    <div class="section">
        <h2>6. Quick Actions</h2>
        <button onclick="location.reload()" style="padding: 10px 20px; margin: 5px;">🔄 Reload Page</button>
        <button onclick="localStorage.clear(); alert('LocalStorage cleared! Please logout and login again.');" style="padding: 10px 20px; margin: 5px;">🗑️ Clear LocalStorage</button>
        <button onclick="window.location.href='{{ route('admin.dashboard') }}'" style="padding: 10px 20px; margin: 5px;">🏠 Go to Dashboard</button>
    </div>
</body>
</html>

