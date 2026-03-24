<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function index(int $perPage = 10, ?string $search = null, ?int $roleId = null): LengthAwarePaginator
    {
        $query = Admin::with('role');

        // Apply role filter if provided
        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('role', function ($roleQuery) use ($search) {
                      $roleQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Admin
    {
        // Hash the password before creating
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Handle location (latitude, longitude) -> POINT
        $location = null;
        if (isset($data['latitude']) && isset($data['longitude'])) {
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
            // MySQL POINT format: POINT(longitude latitude)
            $location = \DB::raw("POINT($longitude, $latitude)");
        }
        
        // Remove lat/long from data array
        unset($data['latitude'], $data['longitude']);
        
        // Create admin
        $admin = new Admin($data);
        
        // Set location if available
        if ($location) {
            $admin->location = $location;
        }
        
        $admin->save();
        
        return $admin;
    }

    public function update(Admin $admin, array $data): Admin
    {
        // Hash the password if it's being updated
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove password from data if it's empty (not being updated)
            unset($data['password']);
        }

        // Handle location (latitude, longitude) -> POINT
        $location = null;
        if (isset($data['latitude']) && isset($data['longitude'])) {
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
            // MySQL POINT format: POINT(longitude latitude)
            $location = \DB::raw("POINT($longitude, $latitude)");
        }
        
        // Remove lat/long from data array
        unset($data['latitude'], $data['longitude']);

        // Update admin
        $admin->fill($data);
        
        // Set location if available
        if ($location) {
            $admin->location = $location;
        }
        
        $admin->save();
        
        return $admin->fresh();
    }

    public function delete(Admin $admin): bool
    {
        return $admin->delete();
    }

    public function find(int $id): ?Admin
    {
        return Admin::with('role')->findOrFail($id);
    }
}

