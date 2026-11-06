<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternetPlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_plan';

    protected $fillable = [
        'id_tipo',
        'nombre_plan',
        'precio',
        'precio_regular',
        'es_promocional',
        'velocidad',
    ];

    protected $casts = [
        'precio'         => 'float',
        'precio_regular' => 'float',
        'es_promocional' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(InternetType::class, 'id_tipo');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'id_plan');
    }
}
