@extends('admin.layouts.app')

@section('title', 'Responsive Layout Demo')
@section('page-title', 'Responsive Layout Demo')

@section('breadcrumbs')
    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Home</a></li>
    <li class="text-gray-400">/</li>
    <li class="text-gray-900 dark:text-white">Responsive Demo</li>
@endsection

@section('admin-content')
<div class="space-y-6">
    
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-6 sm:p-8 text-white">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">
            🎉 Fully Responsive Dashboard
        </h1>
        <p class="text-sm sm:text-base lg:text-lg opacity-90">
            This layout adapts perfectly to mobile, tablet, and desktop screens!
        </p>
    </div>

    <!-- Feature Highlights -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="ri-smartphone-line text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Mobile First
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                Optimized for mobile devices with touch-friendly controls
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="ri-menu-fold-line text-2xl text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Toggle Sidebar
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                Hamburger menu with smooth slide-in/out animation
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="ri-shield-check-line text-2xl text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Permission-Based
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                Dynamic menus based on user permissions
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="ri-flashlight-line text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Lightning Fast
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                Session-cached permissions for optimal performance
            </p>
        </div>
    </div>

    <!-- Responsive Grid Demo -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 lg:p-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Responsive Grid System
        </h2>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6">
            Resize your browser to see the grid adapt automatically
        </p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @for($i = 1; $i <= 8; $i++)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 border border-blue-200 dark:border-gray-600">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        Card {{ $i }}
                    </span>
                    <i class="ri-box-3-line text-blue-600 dark:text-blue-400"></i>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-300">
                    • Mobile: 1 column<br>
                    • Tablet: 2 columns<br>
                    • Desktop: 3-4 columns
                </p>
            </div>
            @endfor
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Responsive Table
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @for($i = 1; $i <= 5; $i++)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-xs sm:text-sm">
                                    U{{ $i }}
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        User {{ $i }}
                                    </div>
                                    <div class="sm:hidden text-xs text-gray-500 dark:text-gray-400">
                                        user{{ $i }}@example.com
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                user{{ $i }}@example.com
                            </div>
                        </td>
                        <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Admin
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @can('admins.view')
                            <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-2 sm:mr-3">
                                <i class="ri-eye-line text-base sm:text-lg"></i>
                            </button>
                            @endcan
                            
                            @can('admins.edit')
                            <button class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 mr-2 sm:mr-3">
                                <i class="ri-edit-line text-base sm:text-lg"></i>
                            </button>
                            @endcan
                            
                            @can('admins.delete')
                            <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                <i class="ri-delete-bin-line text-base sm:text-lg"></i>
                            </button>
                            @endcan
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Responsive Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 lg:p-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-6">
            Responsive Form
        </h2>
        
        <form class="space-y-4 sm:space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        First Name
                    </label>
                    <input type="text" 
                           class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base"
                           placeholder="Enter first name">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Last Name
                    </label>
                    <input type="text" 
                           class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base"
                           placeholder="Enter last name">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Email Address
                </label>
                <input type="email" 
                       class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-sm sm:text-base"
                       placeholder="user@example.com">
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-2">
                @can('admins.create')
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors text-sm sm:text-base">
                    <i class="ri-save-line mr-2"></i>
                    Save Changes
                </button>
                @endcan
                
                <button type="button" 
                        class="w-full sm:w-auto px-6 py-2.5 sm:py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors text-sm sm:text-base">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Breakpoint Indicators (For Testing) -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Current Breakpoint
        </h2>
        <div class="space-y-2">
            <div class="sm:hidden px-4 py-2 bg-red-100 text-red-800 rounded-lg font-medium">
                📱 Mobile (<640px)
            </div>
            <div class="hidden sm:block md:hidden px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-medium">
                📱 Small Tablet (640-768px)
            </div>
            <div class="hidden md:block lg:hidden px-4 py-2 bg-green-100 text-green-800 rounded-lg font-medium">
                💻 Tablet (768-1024px)
            </div>
            <div class="hidden lg:block xl:hidden px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-medium">
                🖥️ Desktop (1024-1280px)
            </div>
            <div class="hidden xl:block 2xl:hidden px-4 py-2 bg-purple-100 text-purple-800 rounded-lg font-medium">
                🖥️ Large Desktop (1280-1536px)
            </div>
            <div class="hidden 2xl:block px-4 py-2 bg-indigo-100 text-indigo-800 rounded-lg font-medium">
                🖥️ Extra Large Desktop (>1536px)
            </div>
        </div>
    </div>

</div>
@endsection

