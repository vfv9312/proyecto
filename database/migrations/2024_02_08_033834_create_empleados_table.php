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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_persona');
            $table->text('comentario');
            $table->string('rol_empleado');
            $table->string('fotografia')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('estatus')->default(1);
            $table->foreign('id_persona')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
