<header class="sticky top-0 z-10 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
        
        <!-- Left Section: Hamburger + Collapse + Page Title -->
        <div class="flex items-center space-x-3 sm:space-x-4">
            <!-- Hamburger Menu Button (Mobile Only) -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    type="button"
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                <span class="sr-only">Toggle sidebar</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            <!-- Collapse/Expand Button (Desktop Only) -->
            <button @click="toggleCollapse()" 
                    type="button"
                    class="hidden lg:inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                    title="Toggle Sidebar">
                <i :class="sidebarCollapsed ? 'ri-menu-unfold-line' : 'ri-menu-fold-line'" class="text-xl"></i>
            </button>
            
            <!-- Page Title -->
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">
                    @yield('page-title', 'Dashboard')
                </h1>
                <!-- Breadcrumbs (Optional) -->
                @hasSection('breadcrumbs')
                <nav class="flex mt-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                        @yield('breadcrumbs')
                    </ol>
                </nav>
                @endif
            </div>
        </div>
        
        <!-- Right Section: User Info -->
        <div class="flex items-center space-x-3">
            <!-- User Info (Hidden on Mobile) -->
            <div class="hidden sm:block text-right">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ session('admin_name', 'Admin') }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ session('admin_role_name', 'Administrator') }}
                </p>
            </div>
            
            <!-- Avatar -->
            <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                <span class="text-white font-semibold text-sm sm:text-base">
                    {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                </span>
            </div>
        </div>
    </div>
</header>

