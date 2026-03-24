<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function productAddons(): HasMany
    {
        return $this->hasMany(ProductAddon::class);
    }

    public function orderItemAddons(): HasMany
    {
        return $this->hasMany(OrderItemAddon::class);
    }
}

