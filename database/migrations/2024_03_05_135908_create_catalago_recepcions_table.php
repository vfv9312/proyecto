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
        Schema::create('catalago_recepcions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(2); //2 para mi es pendiente
            $table->foreign('id_producto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalago_recepcions');
    }
};
