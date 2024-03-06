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
        Schema::create('servicios_preventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_preventa')->nullable();
            $table->unsignedBigInteger('id_producto_recepcion')->nullable();
            $table->decimal('costo_total', 8, 2)->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('promocion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(2); //dos para mi es pendiente
            $table->foreign('id_preventa')->references('id')->on('preventas');
            $table->foreign('id_producto_recepcion')->references('id')->on('catalago_recepcions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_preventas');
    }
};
