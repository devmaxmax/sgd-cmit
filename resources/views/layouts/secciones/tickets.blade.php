@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
    <div id="view-tickets" class="content-view">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1">
                    <i class="fas fa-ticket-alt me-2 text-primary"></i> Tickets
                </h2>
                <p class="text-muted small mb-0">Seguimiento de incidencias y tareas.</p>
            </div>
            <button class="btn btn-primary shadow-sm" id="btn-nuevo-ticket">
                <i class="fas fa-plus me-2"></i> Nuevo Ticket
            </button>
        </div>

        <div class="card mb-4 border shadow-sm" style="background-color: #f8f9fa;">
            <div class="card-body p-3">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="filtro-modulo" class="form-label small text-muted fw-bold mb-1">Módulo:</label>
                        <select class="form-select form-select-sm" id="filtro-modulo">
                            <option value="">Todos los Módulos</option>
                            @foreach ($listaModulos as $modulo)
                                <option value="{{ $modulo->id }}">{{ $modulo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-prioridad" class="form-label small text-muted fw-bold mb-1">Prioridad:</label>
                        <select class="form-select form-select-sm" id="filtro-prioridad">
                            <option value="">Todas las Prioridades</option>
                            <option value="urgente">Urgente</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-estado" class="form-label small text-muted fw-bold mb-1">Estado:</label>
                        <select class="form-select form-select-sm" id="filtro-estado">
                            <option value="">Todos los Estados</option>
                            <option value="desarrollo">En desarrollo</option>
                            <option value="pausado">Pausado</option>
                            <option value="terminado">Terminado</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button id="btn-buscar-tickets" class="btn btn-sm btn-primary px-4">
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
                            <th class="border-0">Título</th>
                            <th class="border-0">Proyecto/Módulo</th>
                            <th class="border-0">Prioridad</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0">Inicio</th>
                            <th class="border-0 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-tickets">
                        @foreach ($listaTickets as $ticket)
                            <tr data-modulo-id="{{ $ticket->modulo_id }}" data-prioridad="{{ $ticket->prioridad }}"
                                data-estado="{{ $ticket->estado }}">
                                <td class="fw-bold text-dark">#T-{{ $ticket->id }}</td>
                                <td class="fw-bold">{{ $ticket->titulo }}</td>
                                <td><span class="badge badge-custom badge-info">{{ $ticket->modulo->proyecto->nombre }} /
                                        {{ $ticket->modulo->nombre }}</span></td>
                                <td>
                                    @switch($ticket->prioridad)
                                        @case('urgente')
                                            <span class="badge badge-custom badge-danger">Urgente</span>
                                        @break

                                        @case('alta')
                                            <span class="badge badge-custom badge-warning">Alta</span>
                                        @break

                                        @case('media')
                                            <span class="badge badge-custom badge-info">Media</span>
                                        @break

                                        @case('baja')
                                            <span class="badge badge-custom badge-success">Baja</span>
                                        @break

                                        @default
                                            <span class="badge badge-custom badge-secondary">{{ $ticket->prioridad }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($ticket->estado)
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
                                            <span class="badge bg-secondary">{{ $ticket->estado }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary border-0 me-1 btn-ver-ticket"
                                        data-id="{{ $ticket->id }}" id="btn-ver-ticket" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success border-0 btn-registrar-avance"
                                        data-id="{{ $ticket->id }}" id="btn-registrar-avance" title="Registrar Avance">
                                        <i class="fas fa-chart-line"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success border-0 btn-listado-avances"
                                        data-id="{{ $ticket->id }}" id="btn-listado-avances"
                                        title="Ver listado de avances">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary border-0 me-1 btn-editar-ticket"
                                        id="btn-editar-ticket" data-id="{{ $ticket->id }}" title="Editar Ticket">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-0 btn-eliminar-ticket"
                                        id="btn-eliminar-ticket" data-id="{{ $ticket->id }}" title="Eliminar Ticket">
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
                    Mostrando pagina {{ $listaTickets->currentPage() ?? 0 }} de {{ $listaTickets->lastPage() ?? 0 }} |
                    Total {{ $listaTickets->total() }} tickets
                </small>
                <div>
                    {{ $listaTickets->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" form="form-nuevo-ticket" id="modal-nuevo-ticket" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-title">Nuevo Ticket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-nuevo-ticket">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titulo" class="form-label fw-bold">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modulo_id" class="form-label fw-bold">Módulo</label>
                                <select class="form-select" id="modulo_id" name="modulo_id" required>
                                    <option value="">Seleccione un módulo</option>
                                    @foreach ($listaModulos as $modulo)
                                        <option value="{{ $modulo->id }}">{{ $modulo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prioridad" class="form-label fw-bold">Prioridad</label>
                                <select class="form-select" id="prioridad" name="prioridad" required>
                                    <option value="">Seleccione una prioridad</option>
                                    <option value="urgente">Urgente</option>
                                    <option value="alta">Alta</option>
                                    <option value="media">Media</option>
                                    <option value="baja">Baja</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label fw-bold">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="desarrollo">En desarrollo</option>
                                    <option value="pausado">Pausado</option>
                                    <option value="terminado">Terminado</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Imágenes</label>
                            <div id="contenedor-imagenes-existentes" class="mb-2"></div>
                            <div id="contenedor-imagenes">
                                <div class="input-group mb-2">
                                    <input type="file" class="form-control" name="imagenes[]" accept="image/*">
                                    <button type="button" class="btn btn-outline-secondary btn-eliminar-imagen" disabled>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-agregar-imagen">
                                <i class="fas fa-plus me-1"></i> Agregar otra imagen
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-guardar-nuevo-ticket">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" form="form-ver-ticket" id="modal-ver-ticket" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-title">Ver Ticket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 border border-secondary-subtle rounded p-3">
                        <label class="d-block text-uppercase text-muted small fw-bold mb-1">Título</label>
                        <div id="ver-titulo-ticket" class="fs-5 fw-bold text-dark text-break"></div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-md-4">
                            <div class="border border-secondary-subtle rounded p-2 h-100">
                                <label class="d-block text-uppercase text-muted small fw-bold mb-1">Módulo</label>
                                <div id="ver-modulo-ticket" class="fw-medium"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border border-secondary-subtle rounded p-2 h-100">
                                <label class="d-block text-uppercase text-muted small fw-bold mb-1">Prioridad</label>
                                <div id="ver-prioridad-ticket" class="fw-medium"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border border-secondary-subtle rounded p-2 h-100">
                                <label class="d-block text-uppercase text-muted small fw-bold mb-1">Estado</label>
                                <div id="ver-estado-ticket" class="fw-medium"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 border border-secondary-subtle rounded p-3">
                        <label class="d-block text-uppercase text-muted small fw-bold mb-1">Descripción</label>
                        <div id="ver-descripcion-ticket" class="text-dark text-break" style="white-space: pre-wrap;">
                        </div>
                    </div>

                    <div class="border border-secondary-subtle rounded p-3">
                        <label class="d-block text-uppercase text-muted small fw-bold mb-1">Imágenes</label>
                        <div id="ver-imagenes-ticket"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" form="form-listado-avances" id="modal-listado-avances" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-title">Listado de avances</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="listado-avances"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" form="form-registrar-avance" id="modal-registrar-avance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-title">Registrar avance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-registrar-avance">
                        <div class="mb-3">
                            <span class="text-muted small">Describa el avance que ha tenido en el ticket que se registrará
                                con la fecha y dia de hoy</span>
                            <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn-guardar-nuevo-avance">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="{{ route('assets.private', ['filename' => 'js/tickets/app.js']) }}"></script>

@endsection
