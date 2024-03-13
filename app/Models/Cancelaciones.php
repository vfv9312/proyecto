<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelaciones extends Model
{
    use HasFactory;
    protected $table = "cancelaciones";
    protected $guarded = [
        'id'
    ];
}
