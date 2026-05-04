<?php

namespace App\Http\Controllers;

use App\Models\Avance;
use App\Http\Requests\GuardarAvanceRequest;

use Illuminate\Http\Request;

class AvancesController extends Controller
{
    public function index(Request $request)
    {
        $query = Avance::with(['ticket.user']);

        if ($request->filled('responsable')) {
            $query->whereHas('ticket.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->responsable . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->whereHas('ticket', function ($q) use ($request) {
                $q->where('estado', $request->estado);
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $listaAvances = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('layouts.secciones.avances', compact('listaAvances'));
    }

    public function store(GuardarAvanceRequest $request)
    {
       Avance::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Avance guardado correctamente',
        ]);
    }

    public function obtenerAvances($id)
    {
        $avances = Avance::where('ticket_id', $id)->orderBy('created_at', 'desc')->get();
        return response()->json($avances);
    }
}
