<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodo_pago extends Model
{
    use HasFactory;
    protected $table = "metodo_pago";
    protected $guarded = [
        'id'
    ];
}
