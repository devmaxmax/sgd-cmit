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
            <button class="btn btn-outline-secondary shadow-sm" id="btn-filtros-avanzados">
                <i class="fas fa-filter me-2"></i> Filtros Avanzados
            </button>
        </div>

        <!-- Panel de Filtros (colapsable) -->
        <div class="card-custom mb-4" id="panel-filtros" style="display: none;">
            <div class="card-body">
                <form id="form-filtros-avances">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Ticket</label>
                            <select class="form-select" id="filtro-ticket">
                                <option value="">Todos los tickets</option>
                                <option value="1024">#T-1024 - Error en carga de datos</option>
                                <option value="1023">#T-1023 - Reporte no exporta PDF</option>
                                <option value="1022">#T-1022 - Login no funciona</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Estado del Ticket</label>
                            <select class="form-select" id="filtro-estado">
                                <option value="">Todos los estados</option>
                                <option value="abierto">Abierto</option>
                                <option value="en_progreso">En progreso</option>
                                <option value="revisado">Revisado</option>
                                <option value="cerrado">Cerrado</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Responsable</label>
                            <input type="text" class="form-control" id="filtro-responsable"
                                placeholder="Nombre del responsable">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Fecha Desde</label>
                            <input type="date" class="form-control" id="filtro-fecha-desde">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Fecha Hasta</label>
                            <input type="date" class="form-control" id="filtro-fecha-hasta">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                        <button type="button" class="btn btn-light border me-2" id="btn-limpiar-filtros">
                            <i class="fas fa-times me-1"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Aplicar Filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="card-custom p-0">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                <h6 class="mb-0 fw-bold text-secondary text-uppercase small"><i class="fas fa-list me-2"></i> Avances
                    Registrados</h6>
                <span class="badge bg-white text-secondary border fw-normal" id="total-avances">Total: <span
                        id="contador-avances" class="fw-bold text-primary">0</span> avances</span>
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
                            <th class="border-0 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo-tabla-avances">
                        <!-- Los avances se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>

            <!-- Sin resultados -->
            <div id="sin-resultados" class="text-center py-5" style="display: none;">
                <div class="mb-3">
                    <i class="fas fa-search fa-3x text-light"></i>
                </div>
                <h5 class="text-muted">No se encontraron resultados</h5>
                <p class="text-muted small">Intenta ajustar los filtros de búsqueda.</p>
            </div>

            <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light rounded-bottom">
                <small class="text-muted">Mostrando 0 de 0 avances</small>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection
