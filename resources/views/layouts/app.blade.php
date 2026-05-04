<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CMIT SGD | @yield('title')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ route('assets.private', ['filename' => 'css/style.css']) }}">
</head>

<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-end" id="sidebar-wrapper">
            <div class="sidebar-heading text-white bg-primary p-3 d-flex justify-content-center align-items-center" style="height: 60px;">
                <img src="{{ asset('images/cmit.png') }}" alt="Logo" class="img-fluid sidebar-logo">
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('inicio') ? 'active' : '' }}"
                    href="{{ route('inicio') }}" title="Inicio">
                    <i class="fas fa-home me-2"></i> <span class="nav-text">Inicio</span>
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('proyectos') ? 'active' : '' }}"
                    href="{{ route('proyectos') }}" title="Proyectos">
                    <i class="fas fa-folder me-2"></i> <span class="nav-text">Proyectos</span>
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('modulos') ? 'active' : '' }}"
                    href="{{ route('modulos') }}" title="Módulos">
                    <i class="fas fa-cube me-2"></i> <span class="nav-text">Módulos</span>
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('tickets') ? 'active' : '' }}"
                    href="{{ route('tickets') }}" title="Tickets">
                    <i class="fas fa-ticket-alt me-2"></i> <span class="nav-text">Tickets</span>
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('avances') ? 'active' : '' }}"
                    href="{{ route('avances') }}" title="Avances">
                    <i class="fas fa-chart-line me-2"></i> <span class="nav-text">Avances</span>
                </a>
            </div>
            <div class="mt-auto p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm" title="Salir">
                        <i class="fas fa-sign-out-alt me-2"></i> <span class="nav-text">Salir</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-light" id="sidebarToggle"><i class="fas fa-bars"></i></button>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-center">
                            <li class="nav-item">
                                <span class="nav-link text-secondary">Bienvenido,
                                    <strong>{{ Auth::user()->name }}</strong></span>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar-circle bg-primary text-white ms-2">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#perfilModal">
                                            <i class="fas fa-user-circle me-2 text-primary"></i> Perfil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> Salir
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
        });
    </script>

    <!-- Modal de Perfil (Cambio de Contraseña) -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="perfilModalLabel"><i class="fas fa-user-circle me-2"></i> Mi Perfil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="modal-body p-4">
                        <p class="text-muted small mb-4">Actualiza tu contraseña. Asegúrate de usar una contraseña larga y segura.</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold small text-secondary">Contraseña Actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            @error('current_password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold small text-secondary">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold small text-secondary">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save me-1"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('status') === 'password-updated')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Contraseña actualizada',
                text: 'Tu contraseña ha sido cambiada exitosamente.',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    @endif

    @if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('perfilModal'));
            myModal.show();
        });
    </script>
    @endif
</body>

</html>
