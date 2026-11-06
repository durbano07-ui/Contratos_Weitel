<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('direccion_servicio')->nullable()->after('hora_creacion');
            $table->string('metodo_pago')->nullable()->after('direccion_servicio');
            $table->string('duracion')->default('24')->after('metodo_pago');
            $table->boolean('beneficio_ley')->default(false)->after('duracion');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['direccion_servicio', 'metodo_pago', 'duracion', 'beneficio_ley']);
        });
    }
};
