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
        Schema::create('direcciones_clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_direccion');
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_direccion')->references('id')->on('direcciones');
            $table->foreign('id_cliente')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones_clientes');
    }
};
