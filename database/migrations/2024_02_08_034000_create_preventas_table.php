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
        Schema::create('preventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_direccion')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->boolean('factura')->nullable();
            $table->decimal('costo_total', 8, 2)->nullable();
            $table->text('comentario')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(2); //3 entrega, 4 servicios, 2 inconcluso, 0 eliminado
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_direccion')->references('id')->on('direcciones');
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preventas');
    }
};
