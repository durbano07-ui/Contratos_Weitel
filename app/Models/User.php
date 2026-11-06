<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'role', 'cedula', 'base'])]
#[Hidden(['remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const BASES = ['Guaranda', 'San Miguel'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    // --- Role helpers ---
    public function getAuthPassword()
    {
        return '';
    }

    public function isAdministrador(): bool
    {
        return $this->role === 'administrador';
    }

    public function isAdministrativo(): bool
    {
        return $this->role === 'administrativo';
    }

    public function isTecnico(): bool
    {
        return $this->role === 'tecnico';
    }

    // --- Base helpers ---

    /**
     * Administrador sin base asignada: ve la información de todas las bases.
     */
    public function isAdminGeneral(): bool
    {
        return $this->isAdministrador() && empty($this->base);
    }

    /**
     * Indica si el usuario puede ver/gestionar un contrato según su rol y base.
     */
    public function canAccessContract(\App\Models\Contract $contract): bool
    {
        if ($this->isAdministrativo()) {
            return (int) $contract->id_usuario === (int) $this->id;
        }

        if ($this->isAdministrador()) {
            return $this->isAdminGeneral() || $contract->base === $this->base;
        }

        return false;
    }

    // --- Relationships ---

    public function contracts()
    {
        return $this->hasMany(\App\Models\Contract::class, 'id_usuario');
    }

    public function contratos_asignados()
    {
        return $this->hasMany(\App\Models\Contract::class, 'id_tecnico');
    }
}
