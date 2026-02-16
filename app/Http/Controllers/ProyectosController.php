<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarProyectoRequest;
use App\Http\Requests\ActualizarProyectoRequest;
use App\Models\Proyecto;


class ProyectosController extends Controller
{
    public function index()
    {
        $listaProyectos = Proyecto::orderBy('id', 'desc')->paginate(10);

        return view('layouts.secciones.proyectos', compact('listaProyectos'));
    }

    public function store(GuardarProyectoRequest $request)
    {
        $proyecto = $request->validated();
        Proyecto::create($proyecto);
        return response()->json([
            'message' => 'Proyecto guardado correctamente.'
        ], 201);
    }

    public function show($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        return response()->json($proyecto);
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->delete();
        return response()->json([
            'message' => 'Proyecto eliminado correctamente.'
        ], 200);
    }

    public function update(ActualizarProyectoRequest $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update($request->validated());
        return response()->json([
            'message' => 'Proyecto actualizado correctamente.'
        ], 200);
    }
}
