<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_durations', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('meses')->unique();
            $table->timestamps();
        });

        DB::table('contract_durations')->insert([
            ['meses' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['meses' => 36, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_durations');
    }
};
