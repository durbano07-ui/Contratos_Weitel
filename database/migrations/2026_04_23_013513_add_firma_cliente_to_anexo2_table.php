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
        Schema::table('anexo2', function (Blueprint $table) {
            $table->longText('firma_cliente')->nullable()->after('cantidad_meses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anexo2', function (Blueprint $table) {
            $table->dropColumn('firma_cliente');
        });
    }
};
