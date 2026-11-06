<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDuration extends Model
{
    protected $fillable = ['meses'];

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'duracion', 'meses');
    }
}
