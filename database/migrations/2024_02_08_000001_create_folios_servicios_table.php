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
        Schema::create('folios_servicios', function (Blueprint $table) {
            $table->id();
            $table->char('letra_actual', 3)->default('SER');
            $table->integer('ultimo_valor')->default(0);
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
        Schema::dropIfExists('folios_servicios');
    }
};
