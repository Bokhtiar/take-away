@extends('admin.layouts.app')

@section('title', 'View Menu')
@section('page-title', 'View Menu')

@section('admin-content')
<div class="space-y-6">
    <x-ui.page-header 
        title="View Menu" 
        description="View detailed information about this menu." 
    />
    
    <div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-2 pb-4 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.admin-menus.edit', $adminMenu->id) }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                Edit
            </a>
            <a href="{{ route('admin.admin-menus.index') }}" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                Back
            </a>
        </div>

        <!-- Details -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                <p class="text-gray-900 dark:text-white">{{ $adminMenu->id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Name</label>
                <p class="text-gray-900 dark:text-white text-lg font-medium">{{ $adminMenu->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Slug</label>
                <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded text-gray-900 dark:text-white">{{ $adminMenu->slug }}</span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Icon</label>
                @if($adminMenu->icon)
                    <div class="flex items-center gap-2">
                        <i class="{{ $adminMenu->icon }} text-2xl text-gray-700 dark:text-gray-300"></i>
                        <code class="text-sm text-gray-600 dark:text-gray-400">{{ $adminMenu->icon }}</code>
                    </div>
                @else
                    <p class="text-gray-400">No icon</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">URL</label>
                <p class="text-gray-900 dark:text-white">{{ $adminMenu->url ?? 'N/A' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Parent Menu</label>
                @if($adminMenu->parent)
                    <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 rounded text-sm font-medium">
                        {{ $adminMenu->parent->name }}
                    </span>
                @else
                    <span class="text-gray-600 dark:text-gray-400">Root Menu</span>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Sort Order</label>
                <p class="text-gray-900 dark:text-white">{{ $adminMenu->sort_order }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                @if($adminMenu->is_active)
                    <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 rounded text-sm font-medium">
                        Active
                    </span>
                @else
                    <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 rounded text-sm font-medium">
                        Inactive
                    </span>
                @endif
            </div>

            @if($adminMenu->children->count() > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Child Menus ({{ $adminMenu->children->count() }})</label>
                    <div class="space-y-2">
                        @foreach($adminMenu->children as $child)
                            <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-700/40 rounded">
                                @if($child->icon)
                                    <i class="{{ $child->icon }}"></i>
                                @endif
                                <span class="text-gray-900 dark:text-white">{{ $child->name }}</span>
                                <span class="text-xs text-gray-500">(Order: {{ $child->sort_order }})</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</label>
                    <p class="text-gray-900 dark:text-white">{{ $adminMenu->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Updated At</label>
                    <p class="text-gray-900 dark:text-white">{{ $adminMenu->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

