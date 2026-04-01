@extends('admin.layouts.app')

@section('title', 'Chef Details')
@section('page-title', 'Chef Details')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header title="Chef Details" description="View chef information." />

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    @php
                        $img = $chef->image_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($chef->name) . '&background=0D1B2A&color=fff';
                    @endphp
                    <img src="{{ $img }}" alt="{{ $chef->name }}" class="w-full max-w-xs rounded-xl border border-gray-200 dark:border-gray-700 object-cover">
                </div>
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <div class="text-xs uppercase text-gray-500">Name</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $chef->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase text-gray-500">Designation</div>
                        <div class="text-gray-700 dark:text-gray-300">{{ $chef->designation }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase text-gray-500">Phone</div>
                        <div class="text-gray-700 dark:text-gray-300">{{ $chef->phone }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase text-gray-500">Image URL</div>
                        <div class="text-gray-700 dark:text-gray-300 break-all">{{ $chef->image_url ?: 'N/A' }}</div>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <x-ui.button href="{{ route('admin.chefs.edit', $chef->id) }}" variant="primary">Edit</x-ui.button>
                        <x-ui.button href="{{ route('admin.chefs.index') }}" variant="secondary">Back</x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

