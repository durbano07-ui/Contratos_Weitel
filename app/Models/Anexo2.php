<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo2 extends Model
{
    use HasFactory;

    protected $table = 'anexo2';

    protected $fillable = [
        'id_contrato',
        'equipos',
        'compra_credito',
        'arrendamiento',
        'compra_contado',
        'valor_mensual_arrendamiento',
        'valor_mensual_compra_credito',
        'cantidad_meses',
        'firma_cliente',
        'datos_anexo3',
        'completado_en',
    ];

    protected $casts = [
        'equipos'          => 'array',
        'compra_credito'   => 'boolean',
        'arrendamiento'    => 'boolean',
        'compra_contado'   => 'boolean',
        'datos_anexo3'     => 'array',
        'completado_en'    => 'datetime',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'id_contrato');
    }
}
