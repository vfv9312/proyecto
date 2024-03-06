<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalago_recepcion extends Model
{
    use HasFactory;
    protected $table = "catalago_recepcions";
    protected $guarded = [
        'id'
    ];
}
