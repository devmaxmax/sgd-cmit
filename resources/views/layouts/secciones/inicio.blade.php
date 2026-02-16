@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div id="view-dashboard" class="content-view">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold text-dark mb-0">
                <i class="fas fa-tachometer-alt me-2 text-primary"></i> Panel de Control
            </h2>
        </div>

        <div class="row g-4 mb-5">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom h-100 border-start border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-success">Proyectos</h5>
                                <p class="card-value">{{ $nroProyectos }}</p>
                            </div>
                            <i class="fas fa-folder fa-2x text-success opacity-25"></i>
                        </div>
                        <a href="{{ route('proyectos') }}" class="text-decoration-none text-success fw-bold small">
                            Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom h-100 border-start border-4 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-info">Módulos</h5>
                                <p class="card-value">{{ $nroModulos }}</p>
                            </div>
                            <i class="fas fa-cube fa-2x text-info opacity-25"></i>
                        </div>
                        <a href="{{ route('modulos') }}" class="text-decoration-none text-info fw-bold small">
                            Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom h-100 border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-warning">Tickets Abiertos</h5>
                                <p class="card-value">{{ $nroTickets }}</p>
                            </div>
                            <i class="fas fa-ticket-alt fa-2x text-warning opacity-25"></i>
                        </div>
                        <a href="{{ route('tickets') }}" class="text-decoration-none text-warning fw-bold small">
                            Ver detalles <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom h-100 border-start border-4 border-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title text-danger">Urgentes</h5>
                                <p class="card-value">{{ $nroUrgentes }}</p>
                            </div>
                            <i class="fas fa-exclamation-circle fa-2x text-danger opacity-25"></i>
                        </div>
                        <a href="{{ route('tickets') }}" class="text-decoration-none text-danger fw-bold small">
                            Filtrar urgentes <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Tickets Table -->
        <div class="card-custom mb-4 p-0">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                <h5 class="mb-0 fw-bold text-secondary ps-2">Últimos Tickets</h5>
                <a href="{{ route('tickets') }}" class="btn btn-sm btn-link text-decoration-none fw-bold">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Título</th>
                            <th class="border-0">Módulo</th>
                            <th class="border-0">Estado</th>
                            <th class="border-0">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="fw-bold text-dark">#T-{{ $ticket->id }}</td>
                                <td>{{ $ticket->titulo }}</td>
                                <td><span class="badge badge-custom badge-info">{{ $ticket->modulo->nombre }}</span></td>
                                <td><span class="badge badge-custom badge-warning">{{ $ticket->estado }}</span></td>
                                <td>{{ $ticket->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
