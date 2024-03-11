<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden_recoleccion extends Model
{
    use HasFactory;
    protected $table = "orden_recoleccions";
    protected $guarded = [
        'id'
    ];
    /**
     * Get the user that owns the Orden_recoleccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preventa()
    {
        return $this->belongsTo(Preventa::class, 'id_preventa', 'id');
    }
}
