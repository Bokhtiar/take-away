<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRole extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the admins for this role.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

    /**
     * Get the role-menu-permission mappings.
     */
    public function roleMenuPermissions(): HasMany
    {
        return $this->hasMany(AdminRoleMenuPermission::class, 'role_id');
    }
}
