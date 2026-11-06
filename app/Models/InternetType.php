<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternetType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tipo';

    protected $fillable = ['nombre_tipo'];

    public function plans()
    {
        return $this->hasMany(InternetPlan::class, 'id_tipo');
    }
}
