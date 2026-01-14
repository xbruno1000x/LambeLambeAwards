@extends('layouts.app')

@section('title', 'Lambe Lambe Awards - Início')

@section('content')
<section class="hero" style="background-image: url('{{ asset('images/fundo.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <h1>Lambe Lambe Awards</h1>
        <p class="subtitle">A premiação mais prestigiada entre amigos</p>
        
        @if($edicaoAtiva)
            <div class="mb-4">
                <span class="badge bg-primary text-dark px-3 py-2 edicao-badge">
                    <i class="bi bi-calendar-event me-2"></i>Edição {{ $edicaoAtiva->ano }}
                    @if($edicaoAtiva->titulo)
                        <span class="d-none d-md-inline">-</span>
                        <span class="d-block d-md-inline mt-1 mt-md-0">{{ $edicaoAtiva->titulo }}</span>
                    @endif
                </span>
            </div>
            
            @if($edicaoAtiva->votacao_aberta)
                <a href="{{ route('votacao') }}" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="bi bi-check2-circle me-2"></i>Votar Agora
                </a>
            @else
                <div class="alert alert-warning d-inline-block">
                    <i class="bi bi-clock me-2"></i>A votação ainda não está aberta
                </div>
            @endif
        @else
            <div class="alert alert-warning d-inline-block">
                <i class="bi bi-info-circle me-2"></i>Nenhuma edição ativa no momento
            </div>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-people-fill fs-1 text-gold mb-3"></i>
                        <h5 class="card-title">Indicados</h5>
                        <p class="card-text text-muted">Confira todos os indicados desta edição em cada categoria.</p>
                        <a href="{{ route('indicados') }}" class="btn btn-outline-primary">Ver Indicados</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-check2-square fs-1 text-gold mb-3"></i>
                        <h5 class="card-title">Votação</h5>
                        <p class="card-text text-muted">Vote nos seus favoritos em cada categoria da premiação.</p>
                        <a href="{{ route('votacao') }}" class="btn btn-outline-primary">Votar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <img src="{{ asset('images/icon.png') }}" alt="Troféu" style="width: 60px; height: 60px; object-fit: contain;" class="mb-3">
                        <h5 class="card-title">Vencedores</h5>
                        <p class="card-text text-muted">Veja os vencedores das edições anteriores.</p>
                        <a href="{{ route('vencedores') }}" class="btn btn-outline-primary">Ver Vencedores</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
