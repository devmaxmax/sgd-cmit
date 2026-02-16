<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketImagen;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use App\Models\Modulo;

use App\Http\Requests\GuardarTicketRequest;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::orderBy('id', 'desc');

        if ($request->filled('modulo_id')) {
            $query->where('modulo_id', $request->modulo_id);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $listaTickets = $query->orderByRaw("FIELD(prioridad, 'urgente', 'alta', 'media', 'baja')")->orderBy('id', 'desc')->paginate(10);
        $listaModulos = Modulo::orderBy('id', 'desc')->get();

        return view('layouts.secciones.tickets', compact('listaTickets', 'listaModulos'));
    }

    public function store(GuardarTicketRequest $request)
    {
        $ticket = $request->validated();

        $ticket = Ticket::create($ticket);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $nombre = $imagen->getClientOriginalName();
                $path = $imagen->store('assets/private/tickets/' . $ticket->id);

                TicketImagen::create([
                    'ticket_id' => $ticket->id,
                    'nombre' => $nombre,
                    'path' => $path,
                ]);
            }
        }

        return response()->json(['message' => 'Ticket creado correctamente'], 201);
    }

    public function show($id)
    {
        $ticket = Ticket::with('imagenes', 'modulo')->findOrFail($id);
        return response()->json($ticket);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $request->validate([
            'titulo' => 'required|string|max:255',
            'modulo_id' => 'required|exists:modulos,id',
            'prioridad' => 'required|in:urgente,alta,media,baja',
            'estado' => 'required|in:desarrollo,pausado,terminado',
            'descripcion' => 'required|string',
        ]);

        $ticket->update([
            'titulo' => $request->titulo,
            'modulo_id' => $request->modulo_id,
            'prioridad' => $request->prioridad,
            'estado' => $request->estado,
            'descripcion' => $request->descripcion,
        ]);

        // Handle new images in update if needed, typically separate endpoint or same logic
        if ($request->hasFile('imagenes')) {
             foreach ($request->file('imagenes') as $imagen) {
                $nombre = $imagen->getClientOriginalName();
                $path = $imagen->store('assets/private/tickets/' . $ticket->id);

                TicketImagen::create([
                    'ticket_id' => $ticket->id,
                    'nombre' => $nombre,
                    'path' => $path,
                ]);
            }
        }

        return response()->json(['message' => 'Ticket actualizado correctamente']);
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        // Delete images from storage
        foreach ($ticket->imagenes as $imagen) {
            Storage::delete($imagen->path);
            $imagen->delete(); // cascading delete should handle this but good to be explicit or rely on cascade
        }
        $ticket->delete();
        return response()->json(['message' => 'Ticket eliminado correctamente']);
    }

    public function destroyImagen($id)
    {
        $imagen = TicketImagen::findOrFail($id);
        Storage::delete($imagen->path);
        $imagen->delete();
        return response()->json(['message' => 'Imagen eliminada correctamente']);
    }

    public function verTicket($id)
    {
        $ticket = Ticket::with('imagenes', 'modulo')->findOrFail($id);
        return response()->json($ticket);
    }
}
