<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_domains', function (Blueprint $table) {
            $table->id();
            $table->string('dominio', 100)->unique(); // sin "@", ej: gmail.com
            $table->timestamps();
        });

        $now = now();
        DB::table('email_domains')->insert(array_map(fn ($d) => [
            'dominio' => $d, 'created_at' => $now, 'updated_at' => $now,
        ], ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com', 'yahoo.es', 'live.com', 'icloud.com']));
    }

    public function down(): void
    {
        Schema::dropIfExists('email_domains');
    }
};
