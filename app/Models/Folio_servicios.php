<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folio_servicios extends Model
{
    use HasFactory;
    protected $table = "folios_servicios";
    protected $guarded = [
        'id'
    ];
}
