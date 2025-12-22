<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Lambe Lambe Awards')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="admin-sidebar d-none d-lg-block" style="width: 250px; position: fixed; height: 100vh;">
            <div class="p-4 border-bottom border-gold" style="border-color: rgba(212, 175, 55, 0.3) !important;">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                    <h5 class="text-gold mb-0">
                        <i class="bi bi-trophy-fill me-2"></i>Admin
                    </h5>
                </a>
            </div>
            
            <nav class="mt-3">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.edicoes.index') }}" class="nav-link {{ request()->routeIs('admin.edicoes.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Edições
                </a>
                <a href="{{ route('admin.categorias.index') }}" class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <i class="bi bi-award"></i> Categorias
                </a>
                <a href="{{ route('admin.indicados.index') }}" class="nav-link {{ request()->routeIs('admin.indicados.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Indicados
                </a>
                <a href="{{ route('admin.votos.index') }}" class="nav-link {{ request()->routeIs('admin.votos.index') ? 'active' : '' }}">
                    <i class="bi bi-check2-square"></i> Votos
                </a>
                <a href="{{ route('admin.votos.resultados') }}" class="nav-link {{ request()->routeIs('admin.votos.resultados') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i> Resultados
                </a>
                
                <hr class="my-3" style="border-color: rgba(212, 175, 55, 0.2);">
                
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i> Ver Site
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <i class="bi bi-box-arrow-left"></i> Sair
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-grow-1" style="margin-left: 250px; min-height: 100vh;">
            <!-- Top Header -->
            <header class="admin-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-gold">@yield('page-title', 'Dashboard')</h4>
                </div>
                <div>
                    <span class="text-muted">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </span>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
