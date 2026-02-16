<?php

namespace App\Http\Controllers;

use App\Models\Avance;
use App\Http\Requests\GuardarAvanceRequest;

class AvancesController extends Controller
{
    public function index()
    {
        return view('layouts.secciones.avances');
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
