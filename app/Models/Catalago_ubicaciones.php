<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalago_ubicaciones extends Model
{
    use HasFactory;
    protected $table = "catalago_ubicaciones";
    protected $guarded = [
        'id'
    ];
}
