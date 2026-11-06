<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internet_plans', function (Blueprint $table) {
            $table->id('id_plan');
            $table->unsignedBigInteger('id_tipo');
            $table->string('nombre_plan');
            $table->decimal('precio', 8, 2);
            $table->string('velocidad');
            $table->timestamps();

            $table->foreign('id_tipo')->references('id_tipo')->on('internet_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internet_plans');
    }
};
