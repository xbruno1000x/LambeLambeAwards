@extends('layouts.admin')

@section('page-title', 'Detalhes da Categoria')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="text-gold mb-1">{{ $categoria->nome }}</h4>
        <small class="text-muted">Edição {{ $categoria->edicao->ano }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.indicados.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-1"></i>Adicionar Indicado
        </a>
        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
    </div>
</div>

@if($categoria->descricao)
    <p class="text-muted mb-4">{{ $categoria->descricao }}</p>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">{{ $indicadosComVotos->count() }}</div>
            <div class="stat-label">Indicados</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">{{ $indicadosComVotos->sum('total_votos') }}</div>
            <div class="stat-label">Total de Votos</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">
                @if($indicadosComVotos->count() > 0 && $indicadosComVotos->first()->total_votos > 0)
                    {{ $indicadosComVotos->first()->nome }}
                @else
                    -
                @endif
            </div>
            <div class="stat-label">Líder Atual</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-people me-2"></i>Indicados e Votos</h5>
    </div>
    <div class="card-body">
        @if($indicadosComVotos->count() > 0)
            @php
                $maxVotos = $indicadosComVotos->max('total_votos') ?: 1;
            @endphp
            @foreach($indicadosComVotos as $index => $indicado)
                <div class="d-flex align-items-center mb-3 p-3 rounded" style="background: rgba(212, 175, 55, {{ 0.1 - ($index * 0.02) }});">
                    <span class="me-3 fs-4 fw-bold text-gold" style="width: 30px;">{{ $index + 1 }}º</span>
                    
                    @if($indicado->foto)
                        <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-fill text-gold"></i>
                        </div>
                    @endif
                    
                    <div class="flex-grow-1">
                        <div class="fw-bold">{{ $indicado->nome }}</div>
                        <div class="progress mt-2" style="height: 8px; background: rgba(255,255,255,0.1);">
                            <div class="progress-bar" 
                                 role="progressbar" 
                                 style="width: {{ ($indicado->total_votos / $maxVotos) * 100 }}%; background: linear-gradient(90deg, #D4AF37, #FFD700);">
                            </div>
                        </div>
                    </div>
                    
                    <div class="ms-3 text-end">
                        <span class="fs-4 fw-bold text-gold">{{ $indicado->total_votos }}</span>
                        <small class="d-block text-muted">votos</small>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                Nenhum indicado cadastrado nesta categoria
            </div>
        @endif
    </div>
</div>
@endsection
