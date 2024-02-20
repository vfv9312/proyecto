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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->dateTime('entrega')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_empleado')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
