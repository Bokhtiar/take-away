@extends('admin.layouts.app')

@section('title', isset($chef) ? 'Edit Chef' : 'Create Chef')
@section('page-title', isset($chef) ? 'Edit Chef' : 'Create Chef')

@section('admin-content')
    <div class="space-y-6">
        <x-ui.page-header
            :title="isset($chef) ? 'Edit Chef' : 'Create Chef'"
            description="Add and manage chef profiles."
        />

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <form method="POST" action="{{ isset($chef) ? route('admin.chefs.update', $chef->id) : route('admin.chefs.store') }}" class="space-y-5">
                @csrf
                @if(isset($chef))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-ui.input
                        name="name"
                        label="Name"
                        placeholder="Chef name"
                        :value="old('name', $chef->name ?? '')"
                        required
                    />

                    <x-ui.input
                        name="designation"
                        label="Designation"
                        placeholder="e.g. Executive Chef"
                        :value="old('designation', $chef->designation ?? '')"
                        required
                    />

                    <x-ui.input
                        name="phone"
                        label="Phone"
                        placeholder="01XXXXXXXXX"
                        :value="old('phone', $chef->phone ?? '')"
                        required
                    />

                    <x-ui.input
                        name="image_url"
                        label="Image URL (optional)"
                        placeholder="https://..."
                        :value="old('image_url', $chef->image_url ?? '')"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-ui.input
                        type="password"
                        name="password"
                        label="{{ isset($chef) ? 'Password (leave empty to keep)' : 'Password' }}"
                        placeholder="********"
                        :value="''"
                        :required="!isset($chef)"
                    />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <x-ui.button href="{{ route('admin.chefs.index') }}" variant="secondary">Cancel</x-ui.button>
                    <x-ui.button type="submit" variant="primary">{{ isset($chef) ? 'Update' : 'Create' }}</x-ui.button>
                </div>
            </form>
        </div>
    </div>
@endsection

