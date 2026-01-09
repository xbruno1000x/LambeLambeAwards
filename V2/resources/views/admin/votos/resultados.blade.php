@extends('layouts.admin')

@section('page-title', 'Resultados da Votação')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
    <h5 class="mb-0 fs-6 fs-md-5">Resultados da Votação</h5>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.votos.resultados') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="edicao_id" class="form-label">Selecionar Edição</label>
                <select class="form-select" id="edicao_id" name="edicao_id" onchange="this.form.submit()">
                    @foreach($edicoes as $e)
                        <option value="{{ $e->id }}" {{ $edicao && $edicao->id == $e->id ? 'selected' : '' }}>
                            {{ $e->ano }}{{ $e->titulo ? ' - ' . $e->titulo : '' }}
                            @if($e->ativa) (Ativa) @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@if($edicao)
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-4 col-md-4">
            <div class="stat-card">
                <div class="stat-number">{{ count($resultados) }}</div>
                <div class="stat-label">Categorias</div>
            </div>
        </div>
        <div class="col-4 col-md-4">
            <div class="stat-card">
                <div class="stat-number">{{ collect($resultados)->sum('total_votos') }}</div>
                <div class="stat-label">Total Votos</div>
            </div>
        </div>
        <div class="col-4 col-md-4">
            <div class="stat-card">
                <div class="stat-number">
                    @if($edicao->votacao_aberta)
                        <span class="badge bg-success">Aberta</span>
                    @else
                        <span class="badge bg-secondary">Fechada</span>
                    @endif
                </div>
                <div class="stat-label">Status</div>
            </div>
        </div>
    </div>

    @forelse($resultados as $resultado)
        <div class="card mb-3 mb-md-4">
            <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <h5 class="mb-0 text-gold text-truncate" style="font-size: 0.95rem; max-width: 100%;">
                    <i class="bi bi-award me-1 me-sm-2"></i>{{ $resultado['categoria']->nome }}
                </h5>
                <span class="badge bg-secondary flex-shrink-0">{{ $resultado['total_votos'] }} votos</span>
            </div>
            <div class="card-body p-2 p-sm-3" style="overflow-x: hidden;">
                @if($resultado['indicados']->count() > 0)
                    @php
                        $maxVotos = $resultado['indicados']->max('votos_count') ?: 1;
                    @endphp
                    @foreach($resultado['indicados'] as $index => $indicado)
                        <div class="d-flex align-items-center mb-2 p-2 p-sm-3 rounded {{ $index === 0 && $indicado->votos_count > 0 ? 'border border-gold' : '' }}" 
                             style="background: rgba(212, 175, 55, {{ max(0.02, 0.15 - ($index * 0.03)) }}); overflow: hidden;">
                            <span class="me-2 fw-bold {{ $index === 0 && $indicado->votos_count > 0 ? 'text-gold' : 'text-muted' }} flex-shrink-0" style="min-width: 24px; font-size: 0.9rem;">
                                @if($index === 0 && $indicado->votos_count > 0)
                                    <i class="bi bi-trophy-fill"></i>
                                @else
                                    {{ $index + 1 }}º
                                @endif
                            </span>
                            
                            @if($indicado->foto)
                                <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="rounded-circle me-2 d-none d-sm-block flex-shrink-0" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-none d-sm-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill text-gold"></i>
                                </div>
                            @endif
                            
                            <div class="flex-grow-1" style="min-width: 0; overflow: hidden;">
                                <div class="fw-bold {{ $index === 0 && $indicado->votos_count > 0 ? 'text-gold' : '' }} text-truncate" style="font-size: 0.85rem;">
                                    {{ $indicado->nome }}
                                </div>
                                <div class="progress mt-1" style="height: 6px; background: rgba(255,255,255,0.1);">
                                    <div class="progress-bar" 
                                         role="progressbar" 
                                         style="width: {{ $maxVotos > 0 ? ($indicado->votos_count / $maxVotos) * 100 : 0 }}%; background: linear-gradient(90deg, #D4AF37, #FFD700);">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ms-2 text-end flex-shrink-0" style="min-width: 40px;">
                                <span class="fw-bold {{ $index === 0 && $indicado->votos_count > 0 ? 'text-gold' : '' }}" style="font-size: 1rem;">{{ $indicado->votos_count }}</span>
                                <small class="d-none d-sm-block text-muted" style="font-size: 0.7rem;">votos</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3 text-muted">
                        Nenhum indicado nesta categoria
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-bar-chart fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">Nenhuma categoria cadastrada para esta edição</p>
        </div>
    @endforelse
@else
    <div class="text-center py-5">
        <i class="bi bi-info-circle fs-1 text-muted mb-3 d-block"></i>
        <p class="text-muted">Nenhuma edição disponível</p>
    </div>
@endif
@endsection
