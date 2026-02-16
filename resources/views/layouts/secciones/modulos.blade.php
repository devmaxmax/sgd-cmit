@extends('layouts.app')

@section('title', 'Módulos')

@section('content')

    <div id="view-modulos" class="content-view">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1">
                    <i class="fas fa-cube me-2 text-primary"></i> Módulos
                </h2>
                <p class="text-muted small mb-0">Administración de módulos del sistema.</p>
            </div>
            <button class="btn btn-primary shadow-sm" id="btn-nuevo-modulo">
                <i class="fas fa-plus me-2"></i> Nuevo Módulo
            </button>
        </div>

        <div class="card mb-4 border shadow-sm" style="background-color: #f8f9fa;">
            <div class="card-body p-3">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="filtro-proyecto" class="form-label small text-muted fw-bold mb-1">Proyecto:</label>
                        <select class="form-select form-select-sm" id="filtro-proyecto">
                            <option value="">Todos los Proyectos</option>
                            @foreach ($listaProyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtro-estado" class="form-label small text-muted fw-bold mb-1">Estado:</label>
                        <select class="form-select form-select-sm" id="filtro-estado">
                            <option value="">Todos los Estados</option>
                            <option value="relevamiento">En relevamiento</option>
                            <option value="pausado">Pausado</option>
                            <option value="desarrollo">En desarrollo</option>
                            <option value="terminado">Terminado</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-end">
                        <button id="btn-buscar-modulos" class="btn btn-sm btn-primary px-4">
                            <i class="fas fa-search me-1"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-custom p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Nombre</th>
                            <th class="border-0">Proyecto</th>
                            <th class="border-0">Inicio</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-modulos">
                        @foreach ($listaModulos as $modulo)
                            <tr data-proyecto-id="{{ $modulo->proyecto_id }}" data-estado="{{ $modulo->estado }}">
                                <td class="fw-bold text-dark">{{ '#M-' . str_pad($modulo->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="fw-bold">{{ $modulo->nombre }}</td>
                                <td class="text-primary">{{ $modulo->proyecto->nombre }}</td>
                                <td>{{ $modulo->created_at->format('d M Y') }}</td>
                                <td>
                                    @switch($modulo->estado)
                                        @case('relevamiento')
                                            <span class="badge badge-custom badge-warning">En relevamiento</span>
                                        @break

                                        @case('pausado')
                                            <span class="badge bg-warning text-dark">Pausado</span>
                                        @break

                                        @case('desarrollo')
                                            <span class="badge badge-custom badge-info">En desarrollo</span>
                                        @break

                                        @case('terminado')
                                            <span class="badge badge-custom badge-success">Terminado</span>
                                        @break

                                        @default
                                            <span class="badge badge-custom badge-secondary">{{ $modulo->estado }}</span>
                                    @endswitch
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary border-0 me-1 btn-editar-modulo"
                                        id="btn-editar-modulo" data-id="{{ $modulo->id }}" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-0 btn-eliminar-modulo"
                                        id="btn-eliminar-modulo" data-id="{{ $modulo->id }}" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light rounded-bottom">
                <small class="text-muted">
                    Mostrando pagina {{ $listaModulos->currentPage() ?? 0 }} de {{ $listaModulos->lastPage() ?? 0 }} |
                    Total {{ $listaModulos->total() }} módulos
                </small>
                <div>
                    {{ $listaModulos->links() }}
                </div>
            </div>
        </div>
    </div>

    <div form="modal-nuevo-modulo" class="modal fade" id="modal-nuevo-modulo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-title">Nuevo Módulo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-nuevo-modulo">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Proyecto</label>
                            <select class="form-select" id="proyecto_id" name="proyecto_id">
                                <option value="">Seleccione un proyecto</option>
                                @foreach ($listaProyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="relevamiento">En relevamiento</option>
                                <option value="pausado">Pausado</option>
                                <option value="desarrollo">Desarrollo</option>
                                <option value="terminado">Terminado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-guardar-nuevo-modulo">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="{{ route('assets.private', ['filename' => 'js/modulos/app.js']) }}"></script>

@endsection
