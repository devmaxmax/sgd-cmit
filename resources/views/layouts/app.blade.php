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
            <div class="sidebar-heading text-white bg-primary p-3">
                <img src="{{ asset('images/cmit.png') }}" alt="Logo" class="img-fluid">
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('inicio') ? 'active' : '' }}"
                    href="{{ route('inicio') }}">
                    <i class="fas fa-home me-2"></i> Inicio
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('proyectos') ? 'active' : '' }}"
                    href="{{ route('proyectos') }}">
                    <i class="fas fa-folder me-2"></i> Proyectos
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('modulos') ? 'active' : '' }}"
                    href="{{ route('modulos') }}">
                    <i class="fas fa-cube me-2"></i> Módulos
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('tickets') ? 'active' : '' }}"
                    href="{{ route('tickets') }}">
                    <i class="fas fa-ticket-alt me-2"></i> Tickets
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ request()->routeIs('avances') ? 'active' : '' }}"
                    href="{{ route('avances') }}">
                    <i class="fas fa-chart-line me-2"></i> Avances
                </a>
            </div>
            <div class="mt-auto p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                        <i class="fas fa-sign-out-alt me-2"></i> Salir
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
                            <li class="nav-item">
                                <div class="avatar-circle bg-primary text-white ms-2">
                                    {{ substr(Auth::user()->name, 0, 1) }}</div>
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
</body>

</html>
