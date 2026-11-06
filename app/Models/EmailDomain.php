<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDomain extends Model
{
    protected $fillable = ['dominio'];

    /** Normaliza: minúsculas, sin espacios ni "@" inicial. */
    public static function normalizar(?string $dominio): string
    {
        return ltrim(strtolower(trim((string) $dominio)), '@');
    }

    /** Cantidad de clientes cuyo correo usa este dominio. */
    public function clientesCount(): int
    {
        return Client::where('email', 'like', '%@' . $this->dominio)->count();
    }
}
