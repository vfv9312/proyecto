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
        Schema::table('precios_productos', function (Blueprint $table) {
            $table->decimal('alternativo_uno', 8, 2)->nullable()->after('precio');
            $table->decimal('alternativo_dos', 8, 2)->nullable()->after('alternativo_uno');
            $table->decimal('alternativo_tres', 8, 2)->nullable()->after('alternativo_dos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('precios_productos', function (Blueprint $table) {
            $table->dropColumn(['alternativo_uno', 'alternativo_dos', 'alternativo_tres']);
        });
    }
};
