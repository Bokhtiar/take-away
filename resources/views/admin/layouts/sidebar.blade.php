<!-- Sidebar Component with Hover-Expand -->
<aside @mouseenter="if (sidebarCollapsed && window.innerWidth >= 1024) sidebarHovered = true"
       @mouseleave="if (sidebarCollapsed && window.innerWidth >= 1024) sidebarHovered = false"
       :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            isExpanded ? 'lg:w-72 xl:w-80' : 'lg:w-20'
        ]"
       class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col transform transition-all duration-300 ease-in-out shadow-lg">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 lg:p-5 border-b border-gray-200 dark:border-gray-700">
        <!-- Logo/Brand -->
        <div class="flex items-center overflow-hidden" :class="isExpanded ? '' : 'lg:justify-center lg:w-full'">
            <div class="flex items-center space-x-2">
                <!-- Logo Icon -->
                <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-sm">{{ strtoupper(substr(config('app.name', 'B'), 0, 1)) }}</span>
                </div>
                
                <!-- Brand Text (Shows when expanded OR hovered) -->
                <div x-show="isExpanded || window.innerWidth < 1024" 
                     x-transition:enter="transition-opacity duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="lg:block">
                    <h2 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white whitespace-nowrap">
                        {{ config('app.name', 'BokhtiarPro') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Admin Panel</p>
                </div>
            </div>
        </div>
        
        <!-- Close Button (Mobile Only) -->
        <button @click="sidebarOpen = false" 
                type="button"
                class="lg:hidden inline-flex items-center justify-center p-1.5 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 p-3 lg:p-4 space-y-1 overflow-y-auto overflow-x-hidden" id="dynamicSidebar">
        <!-- Dashboard - Always visible -->
        <a href="{{ route('admin.dashboard') }}"
           @click="sidebarOpen = false"
           :class="isExpanded ? '' : 'lg:justify-center lg:px-2'"
           class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-sm lg:text-base text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group relative {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
            <i class="ri-home-line text-lg lg:text-xl flex-shrink-0" :class="isExpanded ? 'lg:mr-3' : ''"></i>
            <span x-show="isExpanded || window.innerWidth < 1024" 
                  x-transition:enter="transition-opacity duration-200"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition-opacity duration-100"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  class="whitespace-nowrap overflow-hidden">
                Dashboard
            </span>
            
            <!-- Tooltip (only when NOT hovered and collapsed) -->
            <div x-show="sidebarCollapsed && !sidebarHovered && window.innerWidth >= 1024" 
                 class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                Dashboard
            </div>
        </a>

        <!-- Dynamic menus will be injected here by JavaScript -->
    </nav>

    <!-- Collapse/Expand Toggle Button (Desktop Only) -->
    <div class="hidden lg:block p-3 border-t border-gray-200 dark:border-gray-700">
        <button @click="toggleCollapse()"
                type="button"
                :class="isExpanded ? '' : 'justify-center px-2'"
                class="w-full flex items-center px-3 py-2.5 text-sm text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group relative">
            <i :class="sidebarCollapsed ? 'ri-menu-unfold-line' : 'ri-menu-fold-line'" 
               class="text-lg flex-shrink-0"
               :class="isExpanded ? 'mr-3' : ''"></i>
            <span x-show="isExpanded || window.innerWidth < 1024" 
                  x-transition:enter="transition-opacity duration-200"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition-opacity duration-100"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  class="whitespace-nowrap overflow-hidden">
                <span x-text="sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'"></span>
            </span>
            
            <!-- Tooltip (only when NOT hovered and collapsed) -->
            <div x-show="sidebarCollapsed && !sidebarHovered && window.innerWidth >= 1024" 
                 class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                Expand Sidebar
            </div>
        </button>
    </div>

    <!-- Logout Section -->
    <div class="p-3 lg:p-4 border-t border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
            @csrf
            <button type="submit"
                    :class="isExpanded ? '' : 'lg:justify-center lg:px-2'"
                    class="w-full flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-sm lg:text-base text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-medium group relative">
                <i class="ri-logout-box-line text-lg lg:text-xl flex-shrink-0" :class="isExpanded ? 'lg:mr-3' : ''"></i>
                <span x-show="isExpanded || window.innerWidth < 1024" 
                      x-transition:enter="transition-opacity duration-200"
                      x-transition:enter-start="opacity-0"
                      x-transition:enter-end="opacity-100"
                      x-transition:leave="transition-opacity duration-100"
                      x-transition:leave-start="opacity-100"
                      x-transition:leave-end="opacity-0"
                      class="whitespace-nowrap overflow-hidden">
                    Logout
                </span>
                
                <!-- Tooltip (only when NOT hovered and collapsed) -->
                <div x-show="sidebarCollapsed && !sidebarHovered && window.innerWidth >= 1024" 
                     class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                    Logout
                </div>
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔧 Sidebar script loaded');
        renderDynamicSidebar();
    });

    // Filter menus based on access permission
    function filterMenusByPermission(menus) {
        const filtered = {};
        
        for (const menuId in menus) {
            const menu = menus[menuId];
            const menuPermissions = menu.permissions || {};
            
            // Check access permission (list/view sidebar permission)
            const hasAccessPermission = menuPermissions.hasOwnProperty('access');
            
            // Filter children with access permission
            let allowedChildren = [];
            if (menu.children && menu.children.length > 0) {
                allowedChildren = menu.children.filter(child => {
                    const childPerms = child.permissions || {};
                    return childPerms.hasOwnProperty('access');
                });
            }
            
            // Show menu if has access permission OR has allowed children
            if (hasAccessPermission || allowedChildren.length > 0) {
                filtered[menuId] = {
                    ...menu,
                    children: allowedChildren
                };
            }
        }
        
        return filtered;
    }

    function renderDynamicSidebar() {
        console.log('🚀 Starting dynamic sidebar render...');
        
        const sidebar = document.getElementById('dynamicSidebar');
        if (!sidebar) {
            console.error('❌ Sidebar element not found!');
            return;
        }


        // Get admin data from localStorage
        const adminAuthRaw = localStorage.getItem('admin_auth');
        console.log('📦 Admin Auth Raw:', adminAuthRaw);

        if (!adminAuthRaw) {
            console.warn('⚠️ No admin auth data in localStorage');
            return;
        }

        // Parse nested menus and filter by permissions
        const adminAuth = JSON.parse(adminAuthRaw);
        const rootMenus = adminAuth.permissions || {};
        
        console.log('✅ Root Menus:', rootMenus);
        
        if (Object.keys(rootMenus).length === 0) {
            console.warn('⚠️ No menus in localStorage');
            return;
        }

        // Filter menus based on sidebar-menu permission
        const allowedMenus = filterMenusByPermission(rootMenus);
        console.log('✅ Allowed Menus (after filtering):', allowedMenus);

        // Render only allowed menus
        let menusHTML = '';
        for (const menuId in allowedMenus) {
            menusHTML += renderMenuItem(allowedMenus[menuId]);
        }
        
        console.log('📝 Generated HTML, length:', menusHTML.length);
        
        // Append after dashboard
        const dashboardLink = sidebar.querySelector('a[href*="dashboard"]');
        if (dashboardLink) {
            dashboardLink.insertAdjacentHTML('afterend', menusHTML);
            console.log('✅ Menus inserted after dashboard');
        } else {
            sidebar.insertAdjacentHTML('beforeend', menusHTML);
            console.log('✅ Menus appended to sidebar');
        }
        
        console.log('🎉 Dynamic sidebar render complete!');
    }

    function renderMenuItem(menu, level = 0) {
        const hasChildren = menu.children && menu.children.length > 0;
        const isActive = menu.menu_url && window.location.pathname.startsWith(menu.menu_url);
        const indent = level * 12;
        const basePadding = 12;
        
        let html = '';

        if (hasChildren) {
            // Parent with children (accordion)
            const iconClass = menu.menu_icon || 'ri-folder-line';
            html += `<div class="menu-group" x-data="{ expanded: false }">
                <button type="button" 
                        @click="expanded = !expanded; if (isExpanded) toggleSubmenu('sub-${menu.menu_id}')"
                        :class="isExpanded ? '' : 'lg:justify-center lg:px-2'"
                        class="w-full flex items-center justify-between px-3 lg:px-4 py-2.5 lg:py-3 text-sm lg:text-base text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 font-medium group relative"
                        style="padding-left:${basePadding+indent}px">
                    <span class="flex items-center overflow-hidden">
                        <i class="${iconClass} text-lg lg:text-xl flex-shrink-0" 
                           :class="isExpanded ? 'lg:mr-3' : ''"></i>
                        <span x-show="isExpanded || window.innerWidth < 1024" 
                              x-transition:enter="transition-opacity duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              x-transition:leave="transition-opacity duration-100"
                              x-transition:leave-start="opacity-100"
                              x-transition:leave-end="opacity-0"
                              class="whitespace-nowrap overflow-hidden text-ellipsis">
                            ${menu.menu_name}
                        </span>
                    </span>
                    <i class="ri-arrow-down-s-line submenu-icon transition-transform duration-200 text-lg flex-shrink-0"
                       x-show="isExpanded || window.innerWidth < 1024"></i>
                    
                    <!-- Tooltip (only when NOT hovered and collapsed) -->
                    <div x-show="sidebarCollapsed && !sidebarHovered && window.innerWidth >= 1024" 
                         class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                        ${menu.menu_name}
                    </div>
                </button>
                <div id="sub-${menu.menu_id}" 
                     x-show="isExpanded || window.innerWidth < 1024"
                     class="submenu hidden space-y-1 mt-1 pl-2">
                    ${menu.children.map(child => renderMenuItem(child, level + 1)).join('')}
                </div>
            </div>`;
        } else {
            // Leaf menu (child link)
            if (menu.menu_url) {
                const activeClass = isActive ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : '';
                const iconClass = menu.menu_icon || 'ri-file-line';
                html += `<a href="${menu.menu_url}" 
                           @click="sidebarOpen = false"
                           :class="isExpanded ? '' : 'lg:justify-center lg:px-2'"
                           class="flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-sm lg:text-base text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors ${activeClass} group relative"
                           style="padding-left:${basePadding+indent}px">
                    <i class="${iconClass} text-lg lg:text-xl flex-shrink-0"
                       :class="isExpanded ? 'lg:mr-3' : ''"></i>
                    <span x-show="isExpanded || window.innerWidth < 1024" 
                          x-transition:enter="transition-opacity duration-200"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100"
                          x-transition:leave="transition-opacity duration-100"
                          x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap overflow-hidden text-ellipsis">
                        ${menu.menu_name}
                    </span>
                    
                    <!-- Tooltip (only when NOT hovered and collapsed) -->
                    <div x-show="sidebarCollapsed && !sidebarHovered && window.innerWidth >= 1024" 
                         class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                        ${menu.menu_name}
                    </div>
                </a>`;
            }
        }

        return html;
    }

    function toggleSubmenu(childrenId) {
        const submenu = document.getElementById(childrenId);
        const button = submenu.previousElementSibling;
        const icon = button.querySelector('.submenu-icon');
        
        if (submenu.classList.contains('hidden')) {
            submenu.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            submenu.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Auto-expand active parent menus
    function expandActiveMenus() {
        const currentPath = window.location.pathname;
        const allLinks = document.querySelectorAll('#dynamicSidebar a[href]');
        
        allLinks.forEach(link => {
            if (link.href && currentPath.startsWith(new URL(link.href).pathname)) {
                // Find parent submenu and expand it
                let parent = link.closest('.submenu');
                while (parent) {
                    parent.classList.remove('hidden');
                    const button = parent.previousElementSibling;
                    if (button) {
                        const icon = button.querySelector('.submenu-icon');
                        if (icon) icon.style.transform = 'rotate(180deg)';
                    }
                    parent = parent.parentElement.closest('.submenu');
                }
            }
        });
    }

    // Call expand after render
    setTimeout(expandActiveMenus, 100);
</script>
