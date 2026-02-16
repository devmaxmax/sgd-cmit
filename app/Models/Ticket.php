<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modulo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'modulo_id',
    ];
    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function imagenes()
    {
        return $this->hasMany(TicketImagen::class);
    }

    public function avances()
    {
        return $this->hasMany(Avance::class);
    }
}
