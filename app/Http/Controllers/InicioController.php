<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Modulo;

class InicioController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('estado', 'abierto')
            ->limit(10)
            ->orderBy('created_at', 'desc')
            ->get();

        $nroProyectos = Proyecto::whereIn('estado', ['activo', 'pausado', 'cerrado'])->count() ?? 0;
        $nroModulos = Modulo::whereIn('estado', ['relevamiento', 'pausado', 'desarrollo', 'terminado'])->count() ?? 0;
        $nroTickets = Ticket::whereIn('estado', ['activo', 'pausado', 'cerrado'])->count() ?? 0;
        $nroUrgentes = Ticket::where('prioridad', 'urgente')->count() ?? 0;

        

        return view('layouts.secciones.inicio', compact('tickets', 'nroProyectos', 'nroModulos', 'nroTickets', 'nroUrgentes'));
    }
}
