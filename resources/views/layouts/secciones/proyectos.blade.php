@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')

    <div id="view-proyectos" class="content-view">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1">
                    <i class="fas fa-folder me-2 text-primary"></i> Proyectos
                </h2>
                <p class="text-muted small mb-0">Gestiona los proyectos activos y su seguimiento.</p>
            </div>
            <button class="btn btn-primary shadow-sm" id="btn-nuevo-proyecto">
                <i class="fas fa-plus me-2"></i> Nuevo Proyecto
            </button>
        </div>

        <!-- Projects Table -->
        <div class="card-custom p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Nombre</th>
                            <th class="border-0">Descripción</th>
                            <th class="border-0">Inicio</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-proyectos">
                        @foreach ($listaProyectos as $proyecto)
                            <tr>
                                <td class="fw-bold text-dark">{{ '#P-' . str_pad($proyecto['id'], 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="fw-bold text-primary">{{ $proyecto->nombre }}</td>
                                <td class="text-muted">{{ $proyecto->descripcion }}</td>
                                <td>{{ $proyecto->created_at->format('d/m/Y') }}</td>
                                <td><span class="badge badge-custom badge-success">Activo</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary border-0 me-1 btn-editar-proyecto"
                                        id="btn-editar-proyecto" data-id="{{ $proyecto->id }}" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-0 btn-eliminar-proyecto"
                                        id="btn-eliminar-proyecto" data-id="{{ $proyecto->id }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light rounded-bottom">
                <small class="text-muted">
                    Mostrando pagina {{ $listaProyectos->currentPage() ?? 0 }} de {{ $listaProyectos->lastPage() ?? 0 }} |
                    Total {{ $listaProyectos->total() }} proyectos
                </small>
                <div>
                    {{ $listaProyectos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    <div form="modal-nuevo-proyecto" class="modal fade" id="modal-nuevo-proyecto" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-title">Nuevo Proyecto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-nuevo-proyecto">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="activo">Activo</option>
                                <option value="pausado">Pausado</option>
                                <option value="cerrado">Cerrado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-guardar-nuevo-proyecto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="{{ route('assets.private', ['filename' => 'js/proyectos/app.js']) }}"></script>

@endsection
