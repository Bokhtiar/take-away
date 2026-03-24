<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminPermission extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the menus for this permission.
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(AdminMenu::class, 'admin_menu_permission', 'permission_id', 'menu_id')
            ->withTimestamps();
    }

    /**
     * Get the menu-permission mappings.
     */
    public function menuPermissions(): HasMany
    {
        return $this->hasMany(AdminMenuPermission::class, 'permission_id');
    }
}

