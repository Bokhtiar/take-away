@extends('admin.layouts.app')

@section('title', 'Menu Permissions')
@section('page-title', 'Menu Permissions')

@section('admin-content')
    <div class="space-y-6">

        <!-- Header -->
        <x-ui.page-header title="Menu Permissions" description="Assign permissions to menus with collapsible view." />

        <!-- Form -->
        <form method="POST" action="{{ route('admin.admin-menu-permissions.update-bulk') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Accordion Container -->
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($menus as $menu)
                        @php
                            $accordionId = 'menu-' . $menu->id;
                            $hasChildren = $menu->children && $menu->children->count() > 0;
                        @endphp

                        <!-- Menu Accordion Item -->
                        <div class="accordion-item {{ $menu->parent_id === null ? 'border-l-4 border-blue-500' : 'border-l-4 border-gray-300' }}">
                            <!-- Header -->
                            <button type="button" 
                                    class="accordion-header w-full px-6 py-4 flex items-center justify-between text-left
                                           {{ $menu->parent_id === null ? 'bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100' : 'bg-gray-50 dark:bg-gray-700/30 hover:bg-gray-100' }} 
                                           dark:hover:bg-gray-700/50 transition-colors"
                                    onclick="toggleAccordion('{{ $accordionId }}')">
                                <div class="flex items-center gap-3">
                                    @if($menu->icon)
                                        <i class="{{ $menu->icon }} text-xl {{ $menu->parent_id === null ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }}"></i>
                                    @endif
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $menu->name }}</span>
                                    @if($menu->parent_id === null)
                                        <span class="px-2 py-0.5 text-xs font-medium bg-blue-200 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-full">
                                            ROOT
                                        </span>
                                    @endif
                                    @if($hasChildren)
                                        <span class="text-xs text-gray-600 dark:text-gray-400">({{ $menu->children->count() }} children)</span>
                                    @endif
                                </div>
                                <i class="ri-arrow-down-s-line text-xl {{ $menu->parent_id === null ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} accordion-icon transition-transform duration-200"></i>
                            </button>

                            <!-- Body -->
                            <div id="{{ $accordionId }}" class="accordion-body hidden">
                                <!-- Menu Permissions -->
                                <div class="px-6 py-4 {{ $menu->parent_id === null ? 'bg-blue-50/50 dark:bg-blue-900/10' : 'bg-gray-50/50 dark:bg-gray-700/10' }}">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="text-xs font-semibold {{ $menu->parent_id === null ? 'text-blue-800 dark:text-blue-300' : 'text-gray-800 dark:text-gray-300' }} uppercase tracking-wide">
                                            Permissions
                                        </div>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" 
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                          focus:ring-blue-500 cursor-pointer select-all-menu-{{ $menu->id }}"
                                                   onchange="toggleAllMenu({{ $menu->id }})">
                                            <span class="text-xs font-medium {{ $menu->parent_id === null ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">Select All</span>
                                        </label>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                                        @foreach($permissions as $permission)
                                            @php
                                                $hasPermission = $menuPermissions[$menu->id][$permission->id] ?? false;
                                            @endphp
                                            <label class="flex items-center gap-2 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 
                                                          hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-all">
                                                <input 
                                                    type="checkbox" 
                                                    name="permissions[{{ $menu->id }}][]" 
                                                    value="{{ $permission->id }}"
                                                    {{ $hasPermission ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                           focus:ring-blue-500 cursor-pointer permission-checkbox-{{ $menu->id }}">
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $permission->name }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $permission->slug }}</div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Child Menus -->
                                @if($hasChildren)
                                    <div class="border-t border-gray-200 dark:border-gray-700">
                                        @foreach($menu->children as $child)
                                            @php
                                                $childAccordionId = 'child-menu-' . $child->id;
                                            @endphp
                                            
                                            <div class="border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                                <!-- Child Header -->
                                                <button type="button" 
                                                        class="child-accordion-header w-full px-8 py-3 flex items-center justify-between text-left
                                                               bg-gray-50 dark:bg-gray-700/20 hover:bg-gray-100 dark:hover:bg-gray-700/40 transition-colors"
                                                        onclick="toggleAccordion('{{ $childAccordionId }}')">
                                                    <div class="flex items-center gap-3">
                                                        @if($child->icon)
                                                            <i class="{{ $child->icon }} text-gray-600 dark:text-gray-400"></i>
                                                        @endif
                                                        <span class="font-medium text-gray-900 dark:text-white">{{ $child->name }}</span>
                                                        <span class="px-2 py-0.5 text-xs font-medium bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full">
                                                            CHILD
                                                        </span>
                                                    </div>
                                                    <i class="ri-arrow-down-s-line text-gray-600 dark:text-gray-400 accordion-icon transition-transform duration-200"></i>
                                                </button>

                                                <!-- Child Body -->
                                                <div id="{{ $childAccordionId }}" class="accordion-body hidden">
                                                    <div class="px-8 py-4 bg-white dark:bg-gray-800">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                                                Permissions
                                                            </div>
                                                            <label class="flex items-center gap-2 cursor-pointer">
                                                                <input type="checkbox" 
                                                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                                              focus:ring-blue-500 cursor-pointer select-all-menu-{{ $child->id }}"
                                                                       onchange="toggleAllMenu({{ $child->id }})">
                                                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Select All</span>
                                                            </label>
                                                        </div>

                                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                                                            @foreach($permissions as $permission)
                                                                @php
                                                                    $hasPermission = $menuPermissions[$child->id][$permission->id] ?? false;
                                                                @endphp
                                                                <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-gray-700/20 rounded-lg border border-gray-200 dark:border-gray-600 
                                                                              hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-all">
                                                                    <input 
                                                                        type="checkbox" 
                                                                        name="permissions[{{ $child->id }}][]" 
                                                                        value="{{ $permission->id }}"
                                                                        {{ $hasPermission ? 'checked' : '' }}
                                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                                               focus:ring-blue-500 cursor-pointer permission-checkbox-{{ $child->id }}">
                                                                    <div class="flex-1">
                                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $permission->name }}</div>
                                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $permission->slug }}</div>
                                                                    </div>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                            <i class="ri-inbox-line text-5xl mb-4"></i>
                            <p class="font-medium">No menus found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl 
                                              transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="ri-save-line mr-2"></i>
                    Update Permissions
                </button>
            </div>
        </form>

    </div>
@endsection

@push('admin-scripts')
<script>
    // Toggle accordion
    function toggleAccordion(id) {
        const body = document.getElementById(id);
        const header = body.previousElementSibling;
        const icon = header.querySelector('.accordion-icon');
        
        if (body.classList.contains('hidden')) {
            body.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            body.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Toggle all checkboxes for a menu
    function toggleAllMenu(menuId) {
        const selectAll = document.querySelector(`.select-all-menu-${menuId}`);
        const checkboxes = document.querySelectorAll(`.permission-checkbox-${menuId}`);
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    }
</script>
@endpush
