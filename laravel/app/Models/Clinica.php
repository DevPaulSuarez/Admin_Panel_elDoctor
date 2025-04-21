<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = ['password', 'created_at', 'updated_at'];

    protected $table = 'clinicas';
}
