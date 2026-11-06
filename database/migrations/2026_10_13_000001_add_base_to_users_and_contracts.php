<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Base de trabajo del usuario (Guaranda / San Miguel). Null = administrador general.
        Schema::table('users', function (Blueprint $table) {
            $table->string('base')->nullable()->after('role');
        });

        // Base en la que se generó el contrato (copiada del usuario que lo creó)
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('base')->nullable()->index()->after('id_usuario');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropIndex(['base']);
            $table->dropColumn('base');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('base');
        });
    }
};
