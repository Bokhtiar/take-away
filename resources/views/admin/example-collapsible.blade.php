@extends('admin.layouts.app')

@section('title', 'Collapsible Sidebar Demo')
@section('page-title', 'Collapsible Sidebar Demo')

@section('breadcrumbs')
    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Home</a></li>
    <li class="text-gray-400">/</li>
    <li class="text-gray-900 dark:text-white">Collapsible Demo</li>
@endsection

@section('admin-content')
<div class="space-y-6">
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-xl shadow-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-3">
                    🎨 Collapsible Sidebar Demo
                </h1>
                <p class="text-base lg:text-lg opacity-90 mb-4">
                    Try collapsing and expanding the sidebar to see the magic!
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                        ✅ Desktop Collapse/Expand
                    </span>
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                        ✅ Mobile Toggle
                    </span>
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                        ✅ State Persistence
                    </span>
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                        ✅ Smooth Animations
                    </span>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="h-32 w-32 bg-white bg-opacity-10 rounded-2xl backdrop-blur-sm flex items-center justify-center">
                    <i class="ri-layout-left-2-line text-6xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Instructions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Desktop Instructions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="ri-computer-line text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                        Desktop Mode
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-blue-500 mt-0.5 mr-2"></i>
                            <span>Click the <strong>collapse button</strong> in the header (top-left)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-blue-500 mt-0.5 mr-2"></i>
                            <span>Or click the <strong>collapse button</strong> in the sidebar (bottom)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-blue-500 mt-0.5 mr-2"></i>
                            <span>Sidebar collapses to <strong>icon-only view</strong></span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-blue-500 mt-0.5 mr-2"></i>
                            <span><strong>Hover</strong> over icons to see tooltips</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-blue-500 mt-0.5 mr-2"></i>
                            <span>State <strong>persists</strong> after page reload</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile Instructions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                        <i class="ri-smartphone-line text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                        Mobile Mode
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-green-500 mt-0.5 mr-2"></i>
                            <span>Sidebar is <strong>hidden by default</strong></span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-green-500 mt-0.5 mr-2"></i>
                            <span>Click the <strong>hamburger icon</strong> in header</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-green-500 mt-0.5 mr-2"></i>
                            <span>Sidebar <strong>slides in</strong> from left</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-green-500 mt-0.5 mr-2"></i>
                            <span>Click <strong>overlay</strong> or link to close</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-arrow-right-s-fill text-green-500 mt-0.5 mr-2"></i>
                            <span>Full labels always visible on mobile</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Showcase -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 lg:p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <i class="ri-star-line text-yellow-500 mr-3"></i>
            Key Features
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="p-5 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-700 dark:to-gray-600 rounded-lg border border-blue-200 dark:border-gray-600">
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="ri-save-line text-white text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">
                        State Persistence
                    </h3>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Your collapse/expand preference is saved in <code class="px-1 py-0.5 bg-white dark:bg-gray-800 rounded text-xs">localStorage</code> and persists across browser sessions.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-5 bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-700 dark:to-gray-600 rounded-lg border border-green-200 dark:border-gray-600">
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="ri-animation-line text-white text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">
                        Smooth Animations
                    </h3>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Width transitions (300ms) and opacity fades (200ms) provide a seamless, professional user experience.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-5 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-gray-700 dark:to-gray-600 rounded-lg border border-purple-200 dark:border-gray-600">
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="ri-cursor-line text-white text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">
                        Hover Tooltips
                    </h3>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    When collapsed, hovering over menu icons shows beautiful dark-themed tooltips with full menu names.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="p-5 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-gray-700 dark:to-gray-600 rounded-lg border border-yellow-200 dark:border-gray-600">
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="ri-smartphone-line text-white text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">
                        Mobile Friendly
                    </h3>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Separate hamburger toggle for mobile devices with slide-in/out animation and dark overlay.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="p-5 bg-gradient-to-br from-red-50 to-red-100 dark:from-gray-700 dark:to-gray-600 rounded-lg border border-red-200 dark:border-gray-600">
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 bg-red-500 rounded-lg flex items-center justify-center">
                        <i class="ri-lock-line text-white text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">
                        Permission-Based
                    </h3>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Menu items are dynamically rendered based on user permissions using the <code class="px-1 py-0.5 bg-white dark:bg-gray-800 rounded text-xs">can()</code> helper.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="p-5 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-gray-700 dark:to-gray-600 rounded-lg border border-indigo-200 dark:border-gray-600">
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                        <i class="ri-stack-line text-white text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">
                        Nested Menus
                    </h3>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Parent/child menu structure with accordion-style expansion works perfectly in both states.
                </p>
            </div>
        </div>
    </div>

    <!-- Technical Details -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 px-6 py-4 border-b border-gray-300 dark:border-gray-600">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                <i class="ri-code-s-slash-line text-blue-600 dark:text-blue-400 mr-3"></i>
                Technical Implementation
            </h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Alpine.js State -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <i class="ri-server-line text-green-600 mr-2"></i>
                        Alpine.js State
                    </h3>
                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                        <pre class="text-green-400 text-xs font-mono"><code>x-data="{
  sidebarOpen: false,
  sidebarCollapsed: localStorage
    .getItem('sidebarCollapsed') === 'true',
  
  toggleCollapse() {
    this.sidebarCollapsed = !this.sidebarCollapsed;
    localStorage.setItem(
      'sidebarCollapsed', 
      this.sidebarCollapsed
    );
  }
}"</code></pre>
                    </div>
                </div>

                <!-- CSS Classes -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <i class="ri-palette-line text-purple-600 mr-2"></i>
                        Responsive Classes
                    </h3>
                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                        <pre class="text-purple-400 text-xs font-mono"><code>:class="[
  sidebarCollapsed 
    ? 'lg:w-20'           // Collapsed
    : 'lg:w-72 xl:w-80'   // Expanded
]"

class="transition-all duration-300 ease-in-out"</code></pre>
                    </div>
                </div>
            </div>

            <!-- Width States -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="ri-ruler-line text-blue-600 mr-2"></i>
                    Sidebar Width States
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    State
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Mobile
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Desktop (Expanded)
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Desktop (Collapsed)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="bg-white dark:bg-gray-800">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                    Width
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    <code class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">w-64</code>
                                    <span class="text-xs text-gray-500 ml-2">(256px)</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    <code class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">lg:w-72</code>
                                    <span class="text-xs text-gray-500 ml-2">(288px)</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    <code class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">lg:w-20</code>
                                    <span class="text-xs text-gray-500 ml-2">(80px)</span>
                                </td>
                            </tr>
                            <tr class="bg-gray-50 dark:bg-gray-900">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                    Text Labels
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded text-xs font-medium">
                                        ✓ Visible
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded text-xs font-medium">
                                        ✓ Visible
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded text-xs font-medium">
                                        ✗ Hidden
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                    Tooltips
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded text-xs font-medium">
                                        N/A
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded text-xs font-medium">
                                        Disabled
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded text-xs font-medium">
                                        ✓ Enabled
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-2xl p-8 text-center text-white">
        <h2 class="text-2xl lg:text-3xl font-bold mb-3">
            🎉 Try It Now!
        </h2>
        <p class="text-base lg:text-lg mb-6 opacity-90">
            Click the collapse button to see the sidebar transform
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button @click="toggleCollapse()" 
                    class="px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg flex items-center space-x-2">
                <i :class="$data.sidebarCollapsed ? 'ri-menu-unfold-line' : 'ri-menu-fold-line'" class="text-xl"></i>
                <span x-text="$data.sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'"></span>
            </button>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                Back to Dashboard
            </a>
        </div>
    </div>

</div>
@endsection

