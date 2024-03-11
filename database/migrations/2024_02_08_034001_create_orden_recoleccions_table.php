<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orden_recoleccions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_preventa')->nullable();
            $table->dateTime('Fecha_recoleccion')->nullable();
            $table->dateTime('Fecha_entrega')->nullable();
            $table->text('comentario')->nullable();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(5); //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            $table->timestamps();
            $table->foreign('id_preventa')->references('id')->on('preventas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_recoleccions');
    }
};
