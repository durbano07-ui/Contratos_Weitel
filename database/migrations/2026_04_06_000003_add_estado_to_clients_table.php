<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // 'activo' = cliente activo, 'baja' = dado de baja por el administrador
            $table->string('estado')->default('activo')->after('n_telefono');
            $table->timestamp('fecha_baja')->nullable()->after('estado');
            $table->text('motivo_baja')->nullable()->after('fecha_baja');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['estado', 'fecha_baja', 'motivo_baja']);
        });
    }
};
