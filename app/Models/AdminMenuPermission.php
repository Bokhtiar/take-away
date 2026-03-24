<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminMenuPermission extends Model
{
    protected $table = 'admin_menu_permission';

    protected $fillable = [
        'menu_id',
        'permission_id',
    ];

    /**
     * Get the menu.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(AdminMenu::class, 'menu_id');
    }

    /**
     * Get the permission.
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(AdminPermission::class, 'permission_id');
    }
}

