<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    public function modulos()
    {
        return $this->hasMany(Modulo::class);
    }
}
