<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'unit',
        'stock_qty',
    ];

    protected $casts = [
        'stock_qty' => 'decimal:2',
    ];

    public function productIngredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }
}

