@extends('admin.layouts.app')

@section('title', 'Hover-Expand Sidebar Demo')
@section('page-title', 'Hover-Expand Sidebar')

@section('breadcrumbs')
    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Home</a></li>
    <li class="text-gray-400">/</li>
    <li class="text-gray-900 dark:text-white">Hover-Expand Demo</li>
@endsection

@section('admin-content')
<div class="space-y-6">
    
    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-br from-purple-600 via-blue-600 to-cyan-500 rounded-2xl shadow-2xl overflow-hidden">
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
        <div class="relative p-8 lg:p-12">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-4">
                        <i class="ri-magic-line mr-2"></i>
                        New Feature
                    </div>
                    <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">
                        Hover-Expand Sidebar
                    </h1>
                    <p class="text-lg lg:text-xl text-white text-opacity-90 mb-6 max-w-2xl">
                        The ultimate modern UI pattern: collapsed by default, expands on hover, saves space, looks amazing! 🚀
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-4 py-2 bg-white bg-opacity-10 backdrop-blur-sm rounded-lg text-white text-sm font-medium border border-white border-opacity-20">
                            <i class="ri-mouse-line mr-2"></i>
                            Hover to Expand
                        </span>
                        <span class="px-4 py-2 bg-white bg-opacity-10 backdrop-blur-sm rounded-lg text-white text-sm font-medium border border-white border-opacity-20">
                            <i class="ri-flashlight-line mr-2"></i>
                            Smooth Animations
                        </span>
                        <span class="px-4 py-2 bg-white bg-opacity-10 backdrop-blur-sm rounded-lg text-white text-sm font-medium border border-white border-opacity-20">
                            <i class="ri-save-line mr-2"></i>
                            State Persistence
                        </span>
                    </div>
                </div>
                <div class="hidden xl:block">
                    <div class="h-48 w-48 bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl flex items-center justify-center border border-white border-opacity-20">
                        <i class="ri-layout-left-2-line text-8xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Demo Guide -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Step 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-t-4 border-blue-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">1</span>
                    </div>
                    <i class="ri-cursor-line text-3xl text-blue-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    Move Mouse to Sidebar
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    Simply hover your mouse over the collapsed sidebar. It will instantly expand to show all menu labels and text.
                </p>
                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-xs text-blue-700 dark:text-blue-300 font-medium">
                        <i class="ri-lightbulb-line mr-1"></i>
                        Desktop only (≥1024px)
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-t-4 border-green-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center">
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">2</span>
                    </div>
                    <i class="ri-expand-left-right-line text-3xl text-green-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    Sidebar Expands
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    Width smoothly transitions from 80px to 288px. Text labels fade in with a beautiful opacity animation.
                </p>
                <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <p class="text-xs text-green-700 dark:text-green-300 font-medium">
                        <i class="ri-time-line mr-1"></i>
                        300ms smooth transition
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-t-4 border-purple-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center">
                        <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">3</span>
                    </div>
                    <i class="ri-arrow-left-line text-3xl text-purple-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    Move Away, Collapses
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    When your mouse leaves the sidebar, it smoothly collapses back to icon-only view. More space for content!
                </p>
                <div class="mt-4 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <p class="text-xs text-purple-700 dark:text-purple-300 font-medium">
                        <i class="ri-save-line mr-1"></i>
                        Temporary expansion
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Comparison -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="ri-contrast-2-line mr-3"></i>
                Before vs After
            </h2>
        </div>
        <div class="p-6 lg:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <!-- Before -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mr-3">
                            <i class="ri-close-line text-xl text-red-600 dark:text-red-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Simple Collapse
                        </h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="ri-checkbox-blank-circle-fill text-xs text-gray-400 mt-1.5 mr-3"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Manual toggle button required to expand/collapse
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-checkbox-blank-circle-fill text-xs text-gray-400 mt-1.5 mr-3"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                No quick way to see labels without expanding
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-checkbox-blank-circle-fill text-xs text-gray-400 mt-1.5 mr-3"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Must remember what each icon means
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-checkbox-blank-circle-fill text-xs text-gray-400 mt-1.5 mr-3"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Tooltips on individual items only
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- After -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-3">
                            <i class="ri-check-line text-xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Hover-Expand ✨
                        </h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="ri-checkbox-circle-fill text-lg text-green-500 mt-0.5 mr-3"></i>
                            <span class="text-sm text-gray-900 dark:text-white font-medium">
                                Just hover to see all labels instantly
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-checkbox-circle-fill text-lg text-green-500 mt-0.5 mr-3"></i>
                            <span class="text-sm text-gray-900 dark:text-white font-medium">
                                No button clicks needed for quick peek
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-checkbox-circle-fill text-lg text-green-500 mt-0.5 mr-3"></i>
                            <span class="text-sm text-gray-900 dark:text-white font-medium">
                                Smooth, beautiful animations
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-checkbox-circle-fill text-lg text-green-500 mt-0.5 mr-3"></i>
                            <span class="text-sm text-gray-900 dark:text-white font-medium">
                                Still has manual toggle for permanent expand
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Highlights -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- State Management -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-lg p-6 border border-blue-100 dark:border-gray-600">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="ri-database-2-line text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Smart State Management
                </h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="h-6 w-6 bg-blue-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                        <i class="ri-arrow-right-s-line text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">sidebarCollapsed</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">User's manual preference (localStorage)</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="h-6 w-6 bg-blue-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                        <i class="ri-arrow-right-s-line text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">sidebarHovered</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Temporary hover state (not persisted)</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="h-6 w-6 bg-blue-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                        <i class="ri-arrow-right-s-line text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">isExpanded (computed)</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">!collapsed OR hovered = show text</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animations -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-lg p-6 border border-purple-100 dark:border-gray-600">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="ri-film-line text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    Smooth Animations
                </h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="h-6 w-6 bg-purple-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                        <i class="ri-arrow-right-s-line text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Width Transition</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">80px ↔ 288px in 300ms (ease-in-out)</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="h-6 w-6 bg-purple-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                        <i class="ri-arrow-right-s-line text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Text Fade In</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Opacity 0 → 100% in 200ms</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="h-6 w-6 bg-purple-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                        <i class="ri-arrow-right-s-line text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Text Fade Out</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Opacity 100% → 0 in 100ms (faster)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Test Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="ri-test-tube-line mr-3"></i>
                Try It Now!
            </h2>
        </div>
        <div class="p-6 lg:p-8">
            <div class="prose prose-sm max-w-none dark:prose-invert mb-6">
                <p class="text-gray-700 dark:text-gray-300">
                    Test the hover-expand feature by following these steps:
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border-l-4 border-orange-500">
                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                Ensure Sidebar is Collapsed
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                Click the collapse button if sidebar is expanded
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border-l-4 border-orange-500">
                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                Move Mouse to Sidebar
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                Watch it expand smoothly with all labels visible
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border-l-4 border-orange-500">
                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-white font-bold text-sm">3</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                Move Mouse Away
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                Watch it collapse back to icon-only view
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border-l-4 border-orange-500">
                    <div class="flex items-start">
                        <div class="h-8 w-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <span class="text-white font-bold text-sm">4</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                Repeat & Enjoy!
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                Notice how smooth and natural it feels
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button @click="if (sidebarCollapsed) { /* Already collapsed */ } else { toggleCollapse(); }" 
                        class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors shadow-lg flex items-center justify-center">
                    <i class="ri-arrow-left-right-line mr-2 text-xl"></i>
                    <span>Collapse Sidebar First</span>
                </button>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition-colors flex items-center justify-center">
                    <i class="ri-home-line mr-2"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Browser Support -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
            <i class="ri-global-line text-blue-600 mr-3"></i>
            Browser Support
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="ri-chrome-line text-3xl text-white"></i>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Chrome</p>
                <p class="text-xs text-green-600 dark:text-green-400">✓ Supported</p>
            </div>
            <div class="text-center">
                <div class="h-16 w-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="ri-firefox-line text-3xl text-white"></i>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Firefox</p>
                <p class="text-xs text-green-600 dark:text-green-400">✓ Supported</p>
            </div>
            <div class="text-center">
                <div class="h-16 w-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="ri-edge-line text-3xl text-white"></i>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Edge</p>
                <p class="text-xs text-green-600 dark:text-green-400">✓ Supported</p>
            </div>
            <div class="text-center">
                <div class="h-16 w-16 bg-gradient-to-br from-gray-600 to-gray-800 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="ri-safari-line text-3xl text-white"></i>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Safari</p>
                <p class="text-xs text-green-600 dark:text-green-400">✓ Supported</p>
            </div>
        </div>
    </div>

</div>
@endsection

