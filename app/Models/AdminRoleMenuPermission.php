<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminRoleMenuPermission extends Model
{
    protected $table = 'admin_role_menu_permission';

    protected $fillable = [
        'role_id',
        'menu_permission_id',
        'allow',
    ];

    protected $casts = [
        'allow' => 'boolean',
    ];

    /**
     * Get the role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }

    /**
     * Get the menu permission.
     */
    public function menuPermission(): BelongsTo
    {
        return $this->belongsTo(AdminMenuPermission::class, 'menu_permission_id');
    }
}

