<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Contract extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_contrato';

    protected $fillable = [
        'id_usuario',
        'base',
        'id_tecnico',
        'id_cliente',
        'id_plan',
        'fecha',
        'hora_creacion',
        'direccion_servicio',
        'metodo_pago',
        'datos_pago',
        'duracion',
        'beneficio_ley',
        'pdf_ruta',
        'estado_anexo2',
        'equipos',
    ];

    protected $casts = [
        'datos_pago' => 'array',
        'equipos'    => 'array',
    ];

    /**
     * Contratos visibles para el usuario según su rol y base.
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->isAdministrativo()) {
            return $query->where('id_usuario', $user->id);
        }

        if ($user->isAdministrador() && !$user->isAdminGeneral()) {
            return $query->where('base', $user->base);
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'id_tecnico');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_cliente');
    }

    public function plan()
    {
        return $this->belongsTo(InternetPlan::class, 'id_plan');
    }

    public function anexo2()
    {
        return $this->hasOne(\App\Models\Anexo2::class, 'id_contrato');
    }
}
