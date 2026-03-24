@extends('admin.layouts.app')

@section('title', isset($admin) ? 'Edit Admin' : 'Create Admin')
@section('page-title', isset($admin) ? 'Edit Admin' : 'Create Admin')

@section('admin-content')
<div class="">
    <x-ui.page-header 
        :title="isset($admin) ? 'Edit Admin' : 'Create Admin'" 
        :description="isset($admin) ? 'Update admin user information.' : 'Add a new admin user to the system.'" 
    />
    
    <div class="my-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ isset($admin) ? route('admin.admins.update', $admin->id) : route('admin.admins.store') }}" 
              method="POST" 
              class="space-y-6">
            @csrf
            @if(isset($admin))
                @method('PUT')
            @endif

            <!-- Name -->
            <x-ui.input 
                name="name" 
                type="text" 
                label="Name"
                placeholder="e.g., John Doe"
                value="{{ old('name', $admin->name ?? '') }}"
                required
            />

            <!-- Email -->
            <x-ui.input 
                name="email" 
                type="email" 
                label="Email"
                placeholder="e.g., john@example.com"
                value="{{ old('email', $admin->email ?? '') }}"
                required
            />

            <!-- Phone -->
            <x-ui.input 
                name="phone" 
                type="text" 
                label="Phone"
                placeholder="e.g., +880 1700-000000"
                value="{{ old('phone', $admin->phone ?? '') }}"
                required
            />

            <!-- Role -->
            <x-ui.select 
                name="role_id" 
                label="Role"
                :options="$roles->pluck('name', 'id')->toArray()"
                selected="{{ old('role_id', $admin->role_id ?? '') }}"
                required
            />

            <!-- Hidden Location Fields (Auto-captured) -->
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
            
            <!-- Location Status (Debug) -->
            <div id="locationDebug" class="p-3 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-xs">
                <div class="flex items-center gap-2 mb-1">
                    <i class="ri-map-pin-line"></i>
                    <strong>Location Status:</strong>
                    <span id="locationStatusText" class="text-blue-600 dark:text-blue-400">Detecting...</span>
                </div>
                <div id="locationCoords" class="text-gray-600 dark:text-gray-400"></div>
            </div>

            <!-- Password -->
            <x-ui.input 
                name="password" 
                type="password" 
                label="Password"
                :placeholder="isset($admin) ? 'Leave empty to keep current password' : 'Enter password'"
                :required="!isset($admin)"
            />
            @if(isset($admin))
                <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4 mb-2">Leave empty if you don't want to change the password</p>
            @endif

            <!-- Confirm Password -->
            <x-ui.input 
                name="password_confirmation" 
                type="password" 
                label="Confirm Password"
                :placeholder="isset($admin) ? 'Confirm new password' : 'Confirm password'"
                :required="!isset($admin)"
            />

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <x-ui.button href="{{ route('admin.admins.index') }}" variant="secondary" size="md">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" size="md">
                    {{ isset($admin) ? 'Update Admin' : 'Create Admin' }}
                </x-ui.button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const statusText = document.getElementById('locationStatusText');
        const coordsDiv = document.getElementById('locationCoords');
        
        // Auto-capture geolocation
        if ('geolocation' in navigator) {
            console.log('Geolocation is supported');
            statusText.textContent = 'Requesting permission...';
            statusText.className = 'text-blue-600 dark:text-blue-400';
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    console.log('Location captured:', lat, lng);
                    
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    
                    statusText.textContent = '✓ Captured Successfully';
                    statusText.className = 'text-green-600 dark:text-green-400 font-medium';
                    coordsDiv.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
                },
                function(error) {
                    console.error('Geolocation error:', error);
                    console.error('Error code:', error.code);
                    console.error('Error message:', error.message);
                    
                    let errorMsg = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMsg = '✗ Permission Denied - Please allow location access';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMsg = '✗ Position Unavailable';
                            break;
                        case error.TIMEOUT:
                            errorMsg = '✗ Request Timeout';
                            break;
                        default:
                            errorMsg = '✗ Unknown Error';
                    }
                    
                    statusText.textContent = errorMsg;
                    statusText.className = 'text-red-600 dark:text-red-400 font-medium';
                    coordsDiv.textContent = 'Location will not be saved. You can still submit the form.';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser');
            statusText.textContent = '✗ Not Supported';
            statusText.className = 'text-red-600 dark:text-red-400 font-medium';
            coordsDiv.textContent = 'Your browser does not support geolocation.';
        }
        
        // Form submit করার আগে log করুন
        form.addEventListener('submit', function(e) {
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;
            
            console.log('Form submitting with:', {
                latitude: lat || 'NULL',
                longitude: lng || 'NULL'
            });
        });
    });
</script>
@endpush

