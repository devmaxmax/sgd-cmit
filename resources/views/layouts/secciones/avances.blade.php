@extends('layouts.app')

@section('title', 'Avances')

@section('content')

    <div id="view-avances" class="content-view">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1">
                    <i class="fas fa-chart-line me-2 text-primary"></i> Historial de Avances
                </h2>
                <p class="text-muted small mb-0">Registro cronológico de actividades y actualizaciones.</p>
            </div>
            <form method="GET" action="{{ route('avances') }}" class="card mb-4 border shadow-sm" style="background-color: #f8f9fa;">
                <div class="card-body p-3">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label for="responsable" class="form-label small text-muted fw-bold mb-1">Responsable:</label>
                            <input type="text" class="form-control form-control-sm" name="responsable" id="responsable" placeholder="Nombre..." value="{{ request('responsable') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="estado" class="form-label small text-muted fw-bold mb-1">Estado del Ticket:</label>
                            <select class="form-select form-select-sm" name="estado" id="estado">
                                <option value="">Todos los Estados</option>
                                <option value="desarrollo" {{ request('estado') == 'desarrollo' ? 'selected' : '' }}>En desarrollo</option>
                                <option value="pausado" {{ request('estado') == 'pausado' ? 'selected' : '' }}>Pausado</option>
                                <option value="terminado" {{ request('estado') == 'terminado' ? 'selected' : '' }}>Terminado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="fecha_desde" class="form-label small text-muted fw-bold mb-1">Desde:</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="fecha_hasta" class="form-label small text-muted fw-bold mb-1">Hasta:</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}">
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="submit" class="btn btn-sm btn-primary px-4 w-100">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Resultados -->
        <div class="card-custom p-0">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                <h6 class="mb-0 fw-bold text-secondary text-uppercase small"><i class="fas fa-list me-2"></i> Avances
                    Registrados</h6>
                <span class="badge bg-white text-secondary border fw-normal" id="total-avances">Total: <span
                        id="contador-avances" class="fw-bold text-primary">{{ $listaAvances->total() }}</span> avances</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0" id="tabla-avances">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Fecha</th>
                            <th class="border-0">Ticket</th>
                            <th class="border-0">Estado Ticket</th>
                            <th class="border-0">Responsable</th>
                            <th class="border-0">Observación</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo-tabla-avances">
                        @forelse ($listaAvances as $avance)
                            <tr>
                                <td>{{ $avance->created_at->format('d/m/Y H:i') }}</td>
                                <td class="fw-bold text-dark">
                                    <a href="#" class="text-decoration-none">#T-{{ $avance->ticket->id }}</a><br>
                                    <small class="text-muted fw-normal">{{ $avance->ticket->titulo }}</small>
                                </td>
                                <td>
                                    @switch($avance->ticket->estado)
                                        @case('desarrollo')
                                            <span class="badge bg-info text-dark">En desarrollo</span>
                                        @break
                                        @case('pausado')
                                            <span class="badge bg-warning text-dark">Pausado</span>
                                        @break
                                        @case('terminado')
                                            <span class="badge bg-success">Terminado</span>
                                        @break
                                        @default
                                            <span class="badge bg-secondary">{{ $avance->ticket->estado }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $avance->ticket->user ? $avance->ticket->user->name : 'N/A' }}</td>
                                <td class="text-break" style="max-width: 300px;">{{ $avance->observacion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-search fa-3x text-light"></i>
                                    </div>
                                    <h5 class="text-muted">No se encontraron resultados</h5>
                                    <p class="text-muted small">Intenta ajustar los filtros de búsqueda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light rounded-bottom">
                <small class="text-muted">
                    Mostrando página {{ $listaAvances->currentPage() ?? 0 }} de {{ $listaAvances->lastPage() ?? 0 }}
                </small>
                <div>
                    {{ $listaAvances->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
