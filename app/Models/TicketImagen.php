<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketImagen extends Model
{
    use HasFactory;

    protected $table = 'ticket_imagenes';

    protected $fillable = [
        'ticket_id',
        'nombre',
        'path',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
