<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios_preventas extends Model
{
    use HasFactory;
    protected $table = "servicios_preventas";
    protected $guarded = [
        'id'
    ];
}
