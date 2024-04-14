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
        Schema::create('info_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ubicaciones');
            $table->string('telefono');
            $table->string('whatsapp');
            $table->string('pagina_web');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_tickets');
    }
};
