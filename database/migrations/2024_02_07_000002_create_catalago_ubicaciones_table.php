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
        Schema::create('catalago_ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('cp')->nullable();
            $table->integer('id_estado')->nullable();
            $table->string('estado', 150);
            $table->integer('id_municipio')->nullable();
            $table->string('municipio', 150);
            $table->integer('id_localidad')->nullable();
            $table->string('localidad', 150);
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalago_ubicaciones');
    }
};
