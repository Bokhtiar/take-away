<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chef extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'designation',
        'phone',
        'image_url',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}

