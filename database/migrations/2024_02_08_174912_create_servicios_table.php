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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_venta')->nullable();
            $table->string('tipo_de_proyecto')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('modelo')->nullable();
            $table->string('color')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_venta')->references('id')->on('ventas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
