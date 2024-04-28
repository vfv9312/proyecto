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
        Schema::create('ventas_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_precio_producto');
            $table->unsignedBigInteger('id_preventa')->nullable();
            $table->integer('cantidad');
            $table->decimal('descuento', 8, 2);
            $table->string('tipo_descuento');
            $table->text('descipcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_precio_producto')->references('id')->on('precios_productos');
            $table->foreign('id_preventa')->references('id')->on('preventas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_productos');
    }
};
