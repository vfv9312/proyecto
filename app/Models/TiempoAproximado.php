<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiempoAproximado extends Model
{
    use HasFactory;
    protected $table = "tiemposaproximados";
    protected $guarded = [
        'id'
    ];
}
