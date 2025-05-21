<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management System</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: white !important;
            border-right: 1px solid #dee2e6;
            color: #dc3545;
        }

        .sidebar .nav-link {
            color: black;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #c82333 !important;
            /* darker red */
            color: white !important;
        }

        .sidebar .nav-link {
            color: black;
            transition: color 0.2s ease;
        }

        .sidebar i {
            color: red;
            transition: color 0.2s ease;
        }

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            color: white;
        }

        .navbar {
            background-color: #dc3545 !important;
        }

        /* Icon is red by default */
        .dropdown-menu .dropdown-item .icon-red {
            color: #dc3545;
            /* Bootstrap danger red */
            transition: color 0.2s ease;
        }

        /* On hover or focus, icon becomes white */
        .dropdown-menu .dropdown-item:hover .icon-red,
        .dropdown-menu .dropdown-item:focus .icon-red {
            color: white !important;
        }

        /* Also background and text change on hover */
        .dropdown-menu .dropdown-item:hover,
        .dropdown-menu .dropdown-item:focus {
            background-color: #dc3545 !important;
            color: white !important;
        }
    </style>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('pmlil-logo-Bb7pPR45.svg') }}" alt="Ticket Management System">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }} ({{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }})
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                    style="min-width: 180px;">
                                    @canassigntickets
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2 icon-red"></i> Dashboard
                                        </a>
                                    </li>
                                    @endcanassigntickets

                                    @headofficestaff
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('head_office.dashboard') }}">
                                                <i class="fas fa-tachometer-alt me-2 icon-red"></i> Dashboard
                                            </a>
                                        </li>
                                    @endheadofficestaff

                                    @staff
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('staff.dashboard') }}">
                                                <i class="fas fa-tachometer-alt me-2 icon-red"></i> Dashboard
                                            </a>
                                        </li>
                                    @endstaff

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                                <i class="fas fa-sign-out-alt me-2 icon-red"></i> Logout
                                            </button>
                                        </form>
                                    </li>

                                </ul>

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            @auth
                <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            @canassigntickets
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
                                    href="{{ route('admin.users') }}">
                                    <i class="fas fa-users me-2"></i> Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.departments*') ? 'active' : '' }}"
                                    href="{{ route('admin.departments') }}">
                                    <i class="fas fa-building me-2"></i> Departments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.branches*') ? 'active' : '' }}"
                                    href="{{ route('admin.branches') }}">
                                    <i class="fas fa-code-branch me-2"></i> Branches
                                </a>
                            </li>
                            @endcanassigntickets

                            @headofficestaff
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('head_office.dashboard') ? 'active' : '' }}"
                                        href="{{ route('head_office.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('head_office.tickets.create') ? 'active' : '' }}"
                                        href="{{ route('head_office.tickets.create') }}">
                                        <i class="fas fa-plus-circle me-2"></i> Create Ticket
                                    </a>
                                </li>
                            @endheadofficestaff

                            @staff
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
                                        href="{{ route('staff.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('staff.tickets.create') ? 'active' : '' }}"
                                        href="{{ route('staff.tickets.create') }}">
                                        <i class="fas fa-plus-circle me-2"></i> Create Ticket
                                    </a>
                                </li>
                            @endstaff
                        </ul>
                    </div>
                </div>
            @endauth

            <main class="@auth col-md-9 ms-sm-auto col-lg-10 px-md-4 @endauth py-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <footer class="text-white text-center py-3 mt-auto" style="background-color: #dc3545;">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Prabhu Mahalaxmi Life Insurance Ltd.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
