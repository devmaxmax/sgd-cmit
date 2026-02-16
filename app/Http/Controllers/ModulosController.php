<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Proyecto;
use App\Http\Requests\GuardarModuloRequest;
use App\Http\Requests\ActualizarModuloRequest;

class ModulosController extends Controller
{
    public function index()
    {
        $listaModulos = Modulo::with('proyecto')->orderBy('id', 'desc')->paginate(10);
        $listaProyectos = Proyecto::all();
        return view('layouts.secciones.modulos', compact('listaModulos', 'listaProyectos'));
    }

    public function store(GuardarModuloRequest $request)
    {
        $modulo = $request->validated();
        Modulo::create($modulo);
        return response()->json([
            'message' => 'Modulo guardado correctamente.'
        ], 201);
    }

    public function show($id)
    {
        $modulo = Modulo::findOrFail($id);
        return response()->json($modulo);
    }

    public function destroy($id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->delete();
        return response()->json([
            'message' => 'Modulo eliminado correctamente.'
        ], 200);
    }

    public function update(ActualizarModuloRequest $request, $id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->update($request->validated());
        return response()->json([
            'message' => 'Modulo actualizado correctamente.'
        ], 200);
    }
}
