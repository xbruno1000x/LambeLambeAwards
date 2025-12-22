@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-number">{{ $totalEdicoes }}</div>
            <div class="stat-label">Edições</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-number">{{ $totalCategorias }}</div>
            <div class="stat-label">Categorias</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-number">{{ $totalIndicados }}</div>
            <div class="stat-label">Indicados</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-number">{{ $totalVotos }}</div>
            <div class="stat-label">Votos</div>
        </div>
    </div>
</div>

@if($edicaoAtiva)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Edição Ativa</h5>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="text-gold">
                        {{ $edicaoAtiva->ano }}
                        @if($edicaoAtiva->titulo)
                            - {{ $edicaoAtiva->titulo }}
                        @endif
                    </h3>
                    <p class="mb-0">
                        Status da votação: 
                        @if($edicaoAtiva->votacao_aberta)
                            <span class="badge bg-success">Aberta</span>
                        @else
                            <span class="badge bg-secondary">Fechada</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <form action="{{ route('admin.edicoes.toggle-votacao', $edicaoAtiva) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ $edicaoAtiva->votacao_aberta ? 'btn-danger' : 'btn-success' }}">
                            <i class="bi {{ $edicaoAtiva->votacao_aberta ? 'bi-lock' : 'bi-unlock' }} me-1"></i>
                            {{ $edicaoAtiva->votacao_aberta ? 'Fechar Votação' : 'Abrir Votação' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.edicoes.show', $edicaoAtiva) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-1"></i>Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card mb-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-info-circle fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted mb-3">Nenhuma edição ativa no momento.</p>
            <a href="{{ route('admin.edicoes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Criar Nova Edição
            </a>
        </div>
    </div>
@endif

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <i class="bi bi-calendar-event text-gold fs-1 mb-3 d-block"></i>
                <h5>Gerenciar Edições</h5>
                <p class="text-muted small">Crie e gerencie as edições do prêmio</p>
                <a href="{{ route('admin.edicoes.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-right me-1"></i>Acessar
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <i class="bi bi-award text-gold fs-1 mb-3 d-block"></i>
                <h5>Gerenciar Categorias</h5>
                <p class="text-muted small">Crie categorias para cada edição</p>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-right me-1"></i>Acessar
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <i class="bi bi-people text-gold fs-1 mb-3 d-block"></i>
                <h5>Gerenciar Indicados</h5>
                <p class="text-muted small">Adicione indicados às categorias</p>
                <a href="{{ route('admin.indicados.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-right me-1"></i>Acessar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
