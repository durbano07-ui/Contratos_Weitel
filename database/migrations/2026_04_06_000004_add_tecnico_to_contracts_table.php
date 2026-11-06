<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tecnico')->nullable()->after('id_usuario');
            $table->enum('estado_anexo2', ['pendiente', 'completado'])->default('pendiente')->after('pdf_ruta');

            $table->foreign('id_tecnico')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['id_tecnico']);
            $table->dropColumn(['id_tecnico', 'estado_anexo2']);
        });
    }
};
