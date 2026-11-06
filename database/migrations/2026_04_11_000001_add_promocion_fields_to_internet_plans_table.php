<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internet_plans', function (Blueprint $table) {
            $table->decimal('precio_regular', 8, 2)->nullable()->after('precio');
            $table->boolean('es_promocional')->default(false)->after('precio_regular');
        });
    }

    public function down(): void
    {
        Schema::table('internet_plans', function (Blueprint $table) {
            $table->dropColumn(['precio_regular', 'es_promocional']);
        });
    }
};
