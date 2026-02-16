<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'proyecto_id',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
