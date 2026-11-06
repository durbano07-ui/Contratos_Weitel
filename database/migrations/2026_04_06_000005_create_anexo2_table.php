<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anexo2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_contrato');
            // Equipos instalados (JSON: [{cantidad, precio_unitario, marca, modelo, serial, estado}])
            $table->json('equipos');
            // Modalidad de adquisición
            $table->boolean('compra_credito')->default(false);
            $table->boolean('arrendamiento')->default(false);
            $table->boolean('compra_contado')->default(false);
            // Valores financieros
            $table->decimal('valor_mensual_arrendamiento', 8, 2)->nullable();
            $table->decimal('valor_mensual_compra_credito', 8, 2)->nullable();
            $table->integer('cantidad_meses')->nullable();
            // Auditoría
            $table->timestamp('completado_en')->nullable();
            $table->timestamps();

            $table->foreign('id_contrato')
                  ->references('id_contrato')
                  ->on('contracts')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anexo2');
    }
};
