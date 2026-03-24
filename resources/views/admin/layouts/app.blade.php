<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'BokhtiarPro') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Remix Icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 antialiased">
    <!-- Main Container with Alpine.js state management -->
    <div x-data="{ 
            sidebarOpen: false, 
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            sidebarHovered: false,
            
            toggleCollapse() {
                this.sidebarCollapsed = !this.sidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
            },
            
            // Check if sidebar should be expanded (either manually expanded OR hovered while collapsed)
            get isExpanded() {
                return !this.sidebarCollapsed || (this.sidebarCollapsed && this.sidebarHovered);
            }
        }" 
        class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden"
             style="display: none;">
        </div>

        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        
        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden w-full">
            <!-- Header -->
            @include('admin.layouts.header')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    @yield('admin-content')
                </div>
            </main>
            
            <!-- Footer -->
            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <!-- Toast Notifications -->
    @if(session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
                background: "linear-gradient(to right, #10b981, #059669)",
            },
        }).showToast();
    </script>
    @endif

    @if(session('error'))
    <script>
        Toastify({
            text: "{{ session('error') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
                background: "linear-gradient(to right, #ef4444, #dc2626)",
            },
        }).showToast();
    </script>
    @endif

    <!-- Admin Auth Cache -->
    <script>
        // Store admin data and menu structure in localStorage (UI only)
        @if(session('admin_id'))
            const adminData = {
                id: {{ session('admin_id') }},
                name: "{{ session('admin_name') }}",
                role_id: {{ session('admin_role_id') ?? 'null' }},
                role_name: "{{ session('admin_role_name') ?? '' }}",
                permissions: @json(session('admin_menu_structure', [])),
                cached_at: new Date().toISOString()
            };

            localStorage.setItem('admin_auth', JSON.stringify(adminData));
            console.log('✅ Admin data cached to localStorage:', adminData);
        @else
            // Clear localStorage if no session
            localStorage.removeItem('admin_auth');
            console.log('🗑️ Admin cache cleared');
        @endif

        // Check permission (data contains ONLY allowed permissions now)
        function hasPermission(menuId, permissionSlug) {
            const adminAuth = JSON.parse(localStorage.getItem('admin_auth') || '{}');
            const permissions = adminAuth.permissions || {};
            
            // Check root menus
            if (permissions[menuId]) {
                if (permissions[menuId].permissions && permissions[menuId].permissions.hasOwnProperty(permissionSlug)) {
                    return true; // If exists, it's always allowed
                }
                
                // Check in children
                if (permissions[menuId].children && permissions[menuId].children.length > 0) {
                    for (const child of permissions[menuId].children) {
                        if (child.menu_id == menuId && child.permissions && child.permissions.hasOwnProperty(permissionSlug)) {
                            return true;
                        }
                    }
                }
            }
            
            // Check if menuId is a child in any root menu
            for (const rootMenuId in permissions) {
                const rootMenu = permissions[rootMenuId];
                if (rootMenu.children && rootMenu.children.length > 0) {
                    const child = rootMenu.children.find(c => c.menu_id == menuId);
                    if (child && child.permissions && child.permissions.hasOwnProperty(permissionSlug)) {
                        return true;
                    }
                }
            }
            
            return false;
        }

        // Helper function to get menu permissions
        function getMenuPermissions(menuId) {
            const adminAuth = JSON.parse(localStorage.getItem('admin_auth') || '{}');
            const permissions = adminAuth.permissions || {};
            
            return permissions[menuId] || null;
        }

        // Get all allowed menus (data already filtered)
        function getAllowedMenus() {
            const adminAuth = JSON.parse(localStorage.getItem('admin_auth') || '{}');
            return adminAuth.permissions || {};
        }


        // Helper function to get all cached admin data
        function getAdminAuth() {
            return JSON.parse(localStorage.getItem('admin_auth') || '{}');
        }

        // Helper to check if current URL matches menu
        function isMenuActive(menuUrl) {
            if (!menuUrl) return false;
            const currentPath = window.location.pathname;
            return currentPath.startsWith(menuUrl);
        }

        // Make helpers globally available
        window.hasPermission = hasPermission;
        window.getMenuPermissions = getMenuPermissions;
        window.getAllowedMenus = getAllowedMenus;
        window.getAdminAuth = getAdminAuth;
    </script>

    <!-- Page-specific scripts -->
    @stack('admin-scripts')
</body>
</html>

