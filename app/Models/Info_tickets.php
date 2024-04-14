<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info_tickets extends Model
{
    use HasFactory;
    protected $table = "info_tickets";
    protected $guarded = [
        'id'
    ];
}
