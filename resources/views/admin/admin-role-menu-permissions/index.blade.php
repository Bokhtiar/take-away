@extends('admin.layouts.app')

@section('title', 'Role Menu Permissions')
@section('page-title', 'Role Menu Permissions')

@section('admin-content')
    <div class="space-y-6">

        <!-- Header -->
        <x-ui.page-header title="Role Menu Permissions" description="Assign permissions to menus for each role with an easy accordion view." />

        <!-- Role Selection & Form -->
        <form method="POST" action="{{ route('admin.admin-role-menu-permissions.update-bulk') }}" id="permissionsForm">
            @csrf
            @method('PUT')

            <!-- Role Selector -->
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6">
                <div class="flex items-center gap-4">
                    <label for="roleSelect" class="text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                        Select Role:
                    </label>
                    <select name="role_id" id="roleSelect" required
                        class="flex-1 max-w-md h-11 px-4 text-sm border border-gray-300 dark:border-gray-600 rounded-xl 
                               bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Select a Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $selectedRoleId == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                    @if($selectedRoleId)
                        <button type="button" onclick="window.location.href='{{ route('admin.admin-role-menu-permissions.index') }}'"
                            class="h-11 px-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white 
                                   border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 
                                   hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                            <i class="ri-close-line mr-1"></i>
                            Clear
                        </button>
                    @endif
                </div>
            </div>

            <!-- Permissions Accordion -->
            @if($selectedRoleId && !empty($menuPermissionsGrouped))
                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($menuPermissionsGrouped as $menuGroup)
                            @php
                                $parentMenu = $menuGroup['menu'];
                                $parentPermissions = $menuGroup['permissions'];
                                $children = $menuGroup['children'];
                                $accordionId = 'menu-' . $parentMenu->id;
                            @endphp

                            <!-- Parent Menu Section -->
                            <div class="accordion-item border-l-4 border-blue-500">
                                <!-- Parent Header -->
                                <button type="button" 
                                        class="accordion-header w-full px-6 py-4 flex items-center justify-between text-left
                                               bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors"
                                        onclick="toggleAccordion('{{ $accordionId }}')">
                                    <div class="flex items-center gap-3">
                                        @if($parentMenu->icon)
                                            <i class="{{ $parentMenu->icon }} text-xl text-blue-600 dark:text-blue-400"></i>
                                        @endif
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $parentMenu->name }}</span>
                                        <span class="px-2 py-0.5 text-xs font-medium bg-blue-200 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-full">
                                            PARENT
                                        </span>
                                        @if($children)
                                            <span class="text-xs text-gray-600 dark:text-gray-400">({{ count($children) }} children)</span>
                                        @endif
                                    </div>
                                    <i class="ri-arrow-down-s-line text-xl text-blue-600 dark:text-blue-400 accordion-icon transition-transform duration-200"></i>
                                </button>

                                <!-- Parent & Children Body -->
                                <div id="{{ $accordionId }}" class="accordion-body hidden">
                                    
                                    <!-- Parent Permissions -->
                                    @if($parentPermissions->count() > 0)
                                        <div class="px-6 py-4 bg-blue-50/50 dark:bg-blue-900/10 border-b border-blue-200 dark:border-blue-800">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="text-xs font-semibold text-blue-800 dark:text-blue-300 uppercase tracking-wide">
                                                    Parent Menu Permissions
                                                </div>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" 
                                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                                  focus:ring-blue-500 cursor-pointer select-all-parent-{{ $parentMenu->id }}"
                                                           onchange="toggleAllParent({{ $parentMenu->id }})">
                                                    <span class="text-xs font-medium text-blue-700 dark:text-blue-300">Select All</span>
                                                </label>
                                            </div>
                                            <div class="space-y-2">
                                                @foreach($parentPermissions as $menuPermission)
                                                @php
                                                    $isAllowed = $existingPermissions[$menuPermission->id] ?? false;
                                                @endphp
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-colors cursor-pointer">
                                                    <input type="checkbox" 
                                                           name="permissions[{{ $menuPermission->id }}]" 
                                                           value="1"
                                                           {{ $isAllowed ? 'checked' : '' }}
                                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                                  focus:ring-blue-500 cursor-pointer parent-perm-{{ $parentMenu->id }}">
                                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                                        {{ $menuPermission->permission->name }}
                                                    </span>
                                                    @if($menuPermission->permission->description)
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $menuPermission->permission->description }}
                                                        </span>
                                                    @endif
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Children Menus -->
                                    @if(!empty($children))
                                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/20">
                                            <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-4 uppercase tracking-wide">
                                                Child Menus
                                            </div>
                                            <div class="space-y-4">
                                                @foreach($children as $childData)
                                                    @php
                                                        $childMenu = $childData['menu'];
                                                        $childPermissions = $childData['permissions'];
                                                        $childAccordionId = 'child-menu-' . $childMenu->id;
                                                    @endphp
                                                    
                                                    <!-- Child Menu Card -->
                                                    <div class="ml-8 border-l-4 border-green-500 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm">
                                                        <!-- Child Header -->
                                                        <button type="button"
                                                                class="w-full px-4 py-3 flex items-center justify-between text-left
                                                                       bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors"
                                                                onclick="toggleAccordion('{{ $childAccordionId }}')">
                                                            <div class="flex items-center gap-2">
                                                                @if($childMenu->icon)
                                                                    <i class="{{ $childMenu->icon }} text-green-600 dark:text-green-400"></i>
                                                                @endif
                                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $childMenu->name }}</span>
                                                                <span class="px-2 py-0.5 text-xs font-medium bg-green-200 dark:bg-green-800 text-green-800 dark:text-green-200 rounded-full">
                                                                    CHILD
                                                                </span>
                                                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $childPermissions->count() }} permissions)</span>
                                                            </div>
                                                            <i class="ri-arrow-down-s-line text-green-600 dark:text-green-400 accordion-icon transition-transform duration-200"></i>
                                                        </button>

                                                        <!-- Child Permissions -->
                                                        <div id="{{ $childAccordionId }}" class="accordion-body hidden">
                                                            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900/10">
                                                                <div class="flex items-center justify-end mb-2">
                                                                    <label class="flex items-center gap-2 cursor-pointer">
                                                                        <input type="checkbox" 
                                                                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded 
                                                                                      focus:ring-green-500 cursor-pointer select-all-child-{{ $childMenu->id }}"
                                                                               onchange="toggleAllChild({{ $childMenu->id }})">
                                                                        <span class="text-xs font-medium text-green-700 dark:text-green-300">Select All</span>
                                                                    </label>
                                                                </div>
                                                                <div class="space-y-2">
                                                                    @foreach($childPermissions as $menuPermission)
                                                                        @php
                                                                            $isAllowed = $existingPermissions[$menuPermission->id] ?? false;
                                                                        @endphp
                                                                        <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-green-300 dark:hover:border-green-600 transition-colors cursor-pointer">
                                                                            <input type="checkbox" 
                                                                                   name="permissions[{{ $menuPermission->id }}]" 
                                                                                   value="1"
                                                                                   {{ $isAllowed ? 'checked' : '' }}
                                                                                   class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded 
                                                                                          focus:ring-green-500 cursor-pointer child-perm-{{ $childMenu->id }}">
                                                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                                                                {{ $menuPermission->permission->name }}
                                                                            </span>
                                                                            @if($menuPermission->permission->description)
                                                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                                    {{ $menuPermission->permission->description }}
                                                                                </span>
                                                                            @endif
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl 
                                   transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                                   flex items-center gap-2">
                        <i class="ri-save-line"></i>
                        Update Permissions
                    </button>
                </div>

            @elseif($selectedRoleId && empty($menuPermissionsGrouped))
                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-16">
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="ri-inbox-line text-5xl mb-4 text-gray-400 dark:text-gray-500"></i>
                        <p class="font-medium text-lg">No menu permissions found</p>
                        <p class="text-sm">Please set up menu permissions first before assigning to roles.</p>
                    </div>
                </div>

            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-16">
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="ri-user-settings-line text-5xl mb-4 text-gray-400 dark:text-gray-500"></i>
                        <p class="font-medium text-lg">Select a role to manage permissions</p>
                        <p class="text-sm">Choose a role from the dropdown above to view and edit its menu permissions.</p>
                    </div>
                </div>
            @endif
        </form>

    </div>
@endsection

@push('admin-scripts')
<script>
    // Role selection handler
    document.getElementById('roleSelect')?.addEventListener('change', function() {
        if (this.value) {
            window.location.href = '{{ route("admin.admin-role-menu-permissions.index") }}?role_id=' + this.value;
        } else {
            window.location.href = '{{ route("admin.admin-role-menu-permissions.index") }}';
        }
    });

    // Accordion toggle function
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

    // Toggle all parent permissions
    function toggleAllParent(menuId) {
        const selectAllCheckbox = document.querySelector('.select-all-parent-' + menuId);
        const checkboxes = document.querySelectorAll('.parent-perm-' + menuId);
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
    
    // Toggle all child permissions
    function toggleAllChild(menuId) {
        const selectAllCheckbox = document.querySelector('.select-all-child-' + menuId);
        const checkboxes = document.querySelectorAll('.child-perm-' + menuId);
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }

    // Expand first accordion by default if there's a selected role
    document.addEventListener('DOMContentLoaded', function() {
        const firstAccordion = document.querySelector('.accordion-body');
        if (firstAccordion && {{ $selectedRoleId ? 'true' : 'false' }}) {
            const firstId = firstAccordion.id;
            toggleAccordion(firstId);
        }
    });
</script>
@endpush

