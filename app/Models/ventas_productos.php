<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventas_productos extends Model
{
    use HasFactory;
    protected $table = "ventas_productos";
    protected $guarded = [
        'id'
    ];
}
