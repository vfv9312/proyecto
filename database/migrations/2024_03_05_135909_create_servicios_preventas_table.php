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
            $table->unsignedBigInteger('id_precio_producto')->nullable();
            $table->unsignedBigInteger('id_descuento')->nullable();
            $table->decimal('precio_unitario', 8, 2)->nullable();
            $table->integer('cantidad_total')->nullable();
            $table->Integer('cantidad_resuelto')->nullable();
            $table->decimal('costo_extra')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(2); //2 es un producto de servicio
            $table->foreign('id_preventa')->references('id')->on('preventas');
            $table->foreign('id_producto_recepcion')->references('id')->on('catalago_recepcions');
            $table->foreign('id_descuento')->references('id')->on('descuentos');
            $table->foreign('id_precio_producto')->references('id')->on('precios_productos');
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
