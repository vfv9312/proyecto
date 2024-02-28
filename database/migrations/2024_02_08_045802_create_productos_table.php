<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * $table->decimal('precio', 8, 2);
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_marca');
            $table->unsignedBigInteger('id_tipo');
            $table->string('nombre_comercial');
            $table->string('modelo')->nullable();
            $table->string('color')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('fotografia')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_marca')->references('id')->on('marcas');
            $table->foreign('id_tipo')->references('id')->on('tipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
