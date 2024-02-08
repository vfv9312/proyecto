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
        Schema::create('precios_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio', 8, 2);
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_producto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios_productos');
    }
};
