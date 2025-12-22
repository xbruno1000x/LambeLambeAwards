@extends('layouts.admin')

@section('page-title', 'Detalhes da Edição')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="text-gold mb-1">
            Edição {{ $edicao->ano }}
            @if($edicao->titulo)
                - {{ $edicao->titulo }}
            @endif
        </h4>
        <div>
            @if($edicao->ativa)
                <span class="badge bg-success">Ativa</span>
            @else
                <span class="badge bg-secondary">Inativa</span>
            @endif
            @if($edicao->votacao_aberta)
                <span class="badge bg-success">Votação Aberta</span>
            @else
                <span class="badge bg-secondary">Votação Fechada</span>
            @endif
        </div>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.edicoes.toggle-votacao', $edicao) }}" method="POST">
            @csrf
            <button type="submit" class="btn {{ $edicao->votacao_aberta ? 'btn-warning' : 'btn-success' }}">
                <i class="bi {{ $edicao->votacao_aberta ? 'bi-lock' : 'bi-unlock' }} me-1"></i>
                {{ $edicao->votacao_aberta ? 'Fechar Votação' : 'Abrir Votação' }}
            </button>
        </form>
        
        @if(!$edicao->votacao_aberta && $edicao->categorias->count() > 0)
            <form action="{{ route('admin.edicoes.finalizar', $edicao) }}" method="POST" onsubmit="return confirm('Isso irá calcular os vencedores e encerrar a votação. Continuar?')">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-trophy me-1"></i>Finalizar e Calcular Vencedores
                </button>
            </form>
        @endif
        
        <a href="{{ route('admin.edicoes.edit', $edicao) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">{{ $edicao->categorias->count() }}</div>
            <div class="stat-label">Categorias</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">{{ $edicao->categorias->sum(fn($c) => $c->indicados->count()) }}</div>
            <div class="stat-label">Indicados</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">{{ $edicao->categorias->sum(fn($c) => $c->votos->count()) }}</div>
            <div class="stat-label">Votos</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-award me-2"></i>Categorias</h5>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus me-1"></i>Nova Categoria
        </a>
    </div>
    <div class="card-body">
        @forelse($edicao->categorias as $categoria)
            <div class="card mb-3 bg-dark">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-gold">{{ $categoria->nome }}</h6>
                    <span class="badge bg-secondary">{{ $categoria->votos->count() }} votos</span>
                </div>
                <div class="card-body">
                    @if($categoria->indicados->count() > 0)
                        <div class="row g-3">
                            @foreach($categoria->indicados as $indicado)
                                @php
                                    $votosIndicado = $categoria->votos->where('indicado_id', $indicado->id)->count();
                                @endphp
                                <div class="col-md-6 col-lg-3">
                                    <div class="border rounded p-3 text-center" style="border-color: rgba(212, 175, 55, 0.3) !important;">
                                        @if($indicado->foto)
                                            <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="mx-auto mb-2 rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="bi bi-person-fill text-gold"></i>
                                            </div>
                                        @endif
                                        <div class="fw-bold">{{ $indicado->nome }}</div>
                                        <small class="text-muted">{{ $votosIndicado }} votos</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Nenhum indicado cadastrado</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-muted">
                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                Nenhuma categoria cadastrada para esta edição
            </div>
        @endforelse
    </div>
</div>
@endsection
