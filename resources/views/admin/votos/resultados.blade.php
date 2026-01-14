@extends('layouts.admin')

@section('page-title', 'Resultados da Votação')

@section('content')
<div style="max-width: 100%; overflow-x: hidden;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0" style="font-size: 1rem;">Resultados da Votação</h5>
    </div>

    <div class="card mb-3">
        <div class="card-body p-2 p-sm-3">
            <form action="{{ route('admin.votos.resultados') }}" method="GET">
                <label for="edicao_id" class="form-label" style="font-size: 0.85rem;">Selecionar Edição</label>
                <select class="form-select form-select-sm" id="edicao_id" name="edicao_id" onchange="this.form.submit()">
                    @foreach($edicoes as $e)
                        <option value="{{ $e->id }}" {{ $edicao && $edicao->id == $e->id ? 'selected' : '' }}>
                            {{ $e->ano }}{{ $e->titulo ? ' - ' . $e->titulo : '' }}
                            @if($e->ativa) (Ativa) @endif
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if($edicao)
            <div class="row g-2 mb-3">
                <div class="col-4 d-flex">
                    <div class="stat-card p-2 w-100 h-100">
                        <div class="stat-number" style="font-size: 1.25rem;">{{ count($resultados) }}</div>
                        <div class="stat-label" style="font-size: 0.65rem;">Categorias</div>
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <div class="stat-card p-2 w-100 h-100">
                        <div class="stat-number" style="font-size: 1.25rem;">{{ collect($resultados)->sum('total_votos') }}</div>
                        <div class="stat-label" style="font-size: 0.65rem;">Total Votos</div>
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <div class="stat-card p-2 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="stat-number">
                            @if($edicao->votacao_aberta)
                                <span class="badge bg-success" style="font-size: 0.65rem;">Aberta</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.65rem;">Fechada</span>
                            @endif
                        </div>
                        <div class="stat-label" style="font-size: 0.65rem;">Status</div>
                    </div>
                </div>
            </div>

        @forelse($resultados as $resultado)
            <div class="card mb-3">
                <div class="card-header p-2 p-sm-3">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <span class="text-gold text-truncate fw-bold" style="font-size: 0.85rem; flex: 1; min-width: 0;">
                            <i class="bi bi-award me-1"></i>{{ $resultado['categoria']->nome }}
                        </span>
                        <span class="badge bg-secondary flex-shrink-0" style="font-size: 0.7rem;">{{ $resultado['total_votos'] }}</span>
                    </div>
                </div>
                <div class="card-body p-2">
                    @if($resultado['indicados']->count() > 0)
                        @php
                            $maxVotos = $resultado['indicados']->max('votos_count') ?: 1;
                        @endphp
                        @foreach($resultado['indicados'] as $index => $indicado)
                            <div class="d-flex align-items-center mb-2 p-2 rounded {{ $index === 0 && $indicado->votos_count > 0 ? 'border border-gold' : '' }}" 
                                 style="background: rgba(212, 175, 55, {{ max(0.02, 0.15 - ($index * 0.03)) }});">
                                <span class="fw-bold {{ $index === 0 && $indicado->votos_count > 0 ? 'text-gold' : 'text-muted' }} flex-shrink-0" style="width: 22px; font-size: 0.8rem;">
                                    @if($index === 0 && $indicado->votos_count > 0)
                                        <i class="bi bi-trophy-fill"></i>
                                    @else
                                        {{ $index + 1 }}º
                                    @endif
                                </span>
                                
                                <div style="flex: 1; min-width: 0;">
                                    <div class="fw-bold {{ $index === 0 && $indicado->votos_count > 0 ? 'text-gold' : '' }} text-truncate" style="font-size: 0.8rem;">
                                        {{ $indicado->nome }}
                                    </div>
                                    @if($indicado->descricao)
                                        <div class="text-muted text-truncate" style="font-size: 0.7rem;">
                                            {{ $indicado->descricao }}
                                        </div>
                                    @endif
                                    <div class="progress mt-1" style="height: 4px; background: rgba(255,255,255,0.1);">
                                        <div class="progress-bar" 
                                             role="progressbar" 
                                             style="width: {{ $maxVotos > 0 ? ($indicado->votos_count / $maxVotos) * 100 : 0 }}%; background: linear-gradient(90deg, #D4AF37, #FFD700);">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end flex-shrink-0" style="width: 30px;">
                                    <span class="fw-bold {{ $index === 0 && $indicado->votos_count > 0 ? 'text-gold' : '' }}" style="font-size: 0.85rem;">{{ $indicado->votos_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-3 text-muted" style="font-size: 0.8rem;">
                            Nenhum indicado nesta categoria
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="bi bi-bar-chart fs-2 text-muted mb-2 d-block"></i>
                <p class="text-muted" style="font-size: 0.85rem;">Nenhuma categoria cadastrada para esta edição</p>
            </div>
        @endforelse
    @else
        <div class="text-center py-4">
            <i class="bi bi-info-circle fs-2 text-muted mb-2 d-block"></i>
            <p class="text-muted" style="font-size: 0.85rem;">Nenhuma edição disponível</p>
        </div>
    @endif
</div>
@endsection
