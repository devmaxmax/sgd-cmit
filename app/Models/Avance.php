<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'observacion',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
