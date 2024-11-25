<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaveEliminacion extends Model
{
    use HasFactory;
    protected $table = "_claves_eliminaciones";
    protected $guarded = [
        'id'
    ];
}
