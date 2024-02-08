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
        Schema::create('precios_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_servicio');
            $table->decimal('precio', 8, 2);
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_servicio')->references('id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios_servicios');
    }
};
