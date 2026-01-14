<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lambe Lambe Awards')</title>
    
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://lambelambeawards.ct.ws">
    <meta property="og:title" content="Lambe Lambe Awards">
    <meta property="og:description" content="Vote nos seus favoritos e celebre o melhor do cinema no Lambe Lambe Awards!">
    <meta property="og:image" content="https://lambelambeawards.ct.ws/images/og-preview.jpg">
    <meta property="og:image:secure_url" content="https://lambelambeawards.ct.ws/images/og-preview.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="Lambe Lambe Awards">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', 'Lambe Lambe Awards')">
    <meta name="twitter:description" content="@yield('og_description', 'Vote nos seus favoritos e celebre o melhor do cinema no Lambe Lambe Awards!')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-preview.png'))">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/icon.png') }}" alt="Lambe Lambe Awards" style="width: 30px; height: 30px; object-fit: contain;" class="me-2">Lambe Lambe Awards
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('indicados') ? 'active' : '' }}" href="{{ route('indicados') }}">Indicados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('votacao') ? 'active' : '' }}" href="{{ route('votacao') }}">Votação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vencedores') ? 'active' : '' }}" href="{{ route('vencedores') }}">Vencedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sobre') ? 'active' : '' }}" href="{{ route('sobre') }}">Sobre</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="footer-brand">
                        <img src="{{ asset('images/icon.png') }}" alt="Lambe Lambe Awards" style="width: 25px; height: 25px; object-fit: contain;" class="me-2">Lambe Lambe Awards
                    </span>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">&copy; {{ date('Y') }} Lambe Lambe Awards. Todos os direitos reservados.</small>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
