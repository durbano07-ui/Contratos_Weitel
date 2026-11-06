<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'categoria',
        'stock',
        'stock_minimo',
        'unidad',
        'descripcion',
    ];

    /**
     * Verifica si el stock está en nivel crítico (por debajo del mínimo).
     */
    public function stockBajo(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }
}
