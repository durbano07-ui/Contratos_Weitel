<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'email',
        'direccion',
        'ciudad',
        'canton',
        'parroquia',
        'provincia',
        'n_telefono',
        'estado',
        'fecha_baja',
        'motivo_baja',
    ];

    // --- Identificación ---

    /** Etiqueta del documento según su longitud: 'RUC' (13 dígitos) o 'C.I.' (10 dígitos). */
    public function getTipoIdentificacionAttribute(): string
    {
        return \App\Rules\CedulaRuc::esRuc($this->cedula) ? 'RUC' : 'C.I.';
    }

    // --- Estado helpers ---

    public function isActivo(): bool
    {
        return $this->estado === 'activo';
    }

    public function isBaja(): bool
    {
        return $this->estado === 'baja';
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'id_cliente');
    }
}
