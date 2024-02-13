<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class precios_productos extends Model
{
    use HasFactory;
    protected $table = "precios_productos";
    protected $guarded = [
        'id'
    ];
}
