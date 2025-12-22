@extends('layouts.app')

@section('title', 'Vencedores - Lambe Lambe Awards')

@section('content')
<div style="background-image: url('{{ asset('images/fundo.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.85);"></div>
    <div class="container py-5" style="position: relative; z-index: 1;">
        <h2 class="section-title">
            <img src="{{ asset('images/icon.png') }}" alt="Troféu" style="width: 40px; height: 40px; object-fit: contain;" class="me-2">Vencedores
        </h2>
    
    @if($edicoes->count() > 0)
        @foreach($edicoes as $edicao)
            <div class="card mb-5">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="bi bi-calendar-event me-2"></i>
                        Edição {{ $edicao->ano }}
                        @if($edicao->titulo)
                            - {{ $edicao->titulo }}
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($edicao->vencedores as $vencedor)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-gold" style="cursor: pointer; transition: transform 0.2s;" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#modalDetalhes{{ $vencedor->id }}"
                                     onmouseover="this.style.transform='scale(1.03)'" 
                                     onmouseout="this.style.transform='scale(1)'">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('images/icon.png') }}" alt="Troféu" style="width: 60px; height: 60px; object-fit: contain;" class="mb-3">
                                        <h5 class="text-gold mb-3">{{ $vencedor->categoria->nome }}</h5>
                                        
                                        @if($vencedor->indicado->foto)
                                            <img src="{{ Storage::url($vencedor->indicado->foto) }}" 
                                                 alt="{{ $vencedor->indicado->nome }}" 
                                                 class="rounded-circle mb-3" 
                                                 style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #D4AF37;">
                                        @else
                                            <div class="mx-auto mb-3 rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 80px; border: 3px solid #D4AF37;">
                                                <i class="bi bi-person-fill text-gold fs-3"></i>
                                            </div>
                                        @endif
                                        
                                        <h4 class="mb-2">{{ $vencedor->indicado->nome }}</h4>
                                        
                                        @if($vencedor->indicado->descricao)
                                            <p class="text-muted mb-3">{{ $vencedor->indicado->descricao }}</p>
                                        @endif
                                        
                                        <span class="vencedor-badge">
                                            <i class="bi bi-star-fill"></i>
                                            {{ $vencedor->porcentagem }}% dos votos
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <img src="{{ asset('images/icon.png') }}" alt="Troféu" style="width: 80px; height: 80px; object-fit: contain; opacity: 0.5;" class="mb-3">
            <p class="text-muted fs-5">Nenhum vencedor registrado ainda.</p>
            <p class="text-muted">Os vencedores serão exibidos aqui após o encerramento das votações.</p>
        </div>
    @endif
    </div>
</div>

<!-- Modais de detalhes da votação -->
@if($edicoes->count() > 0)
    @foreach($edicoes as $edicao)
        @foreach($edicao->vencedores as $vencedor)
            <div class="modal fade" id="modalDetalhes{{ $vencedor->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $vencedor->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="background: #1a1a1a; border: 2px solid #D4AF37;">
                        <div class="modal-header" style="border-bottom: 1px solid #D4AF37;">
                            <h5 class="modal-title text-gold" id="modalLabel{{ $vencedor->id }}">
                                <i class="bi bi-bar-chart-fill me-2"></i>Detalhes da Votação
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <h4 class="text-gold mb-2">{{ $vencedor->categoria->nome }}</h4>
                                <p class="text-muted mb-0">Total de votos: <strong>{{ $vencedor->total_votos_categoria }}</strong></p>
                            </div>
                            
                            <div class="list-group">
                                @foreach($vencedor->todosIndicados as $index => $indicado)
                                    <div class="list-group-item {{ $indicado->id == $vencedor->indicado_id ? 'border-gold' : '' }}" 
                                         style="background: {{ $indicado->id == $vencedor->indicado_id ? 'rgba(212, 175, 55, 0.1)' : '#2a2a2a' }}; border: 1px solid {{ $indicado->id == $vencedor->indicado_id ? '#D4AF37' : '#444' }}; margin-bottom: 10px; border-radius: 8px;">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="min-width: 40px;">
                                                @if($index == 0)
                                                    <span class="badge bg-gold text-dark" style="font-size: 1.2rem; padding: 8px 12px;">
                                                        <i class="bi bi-trophy-fill"></i>
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary" style="font-size: 1rem; padding: 6px 10px;">
                                                        {{ $index + 1 }}º
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if($indicado->foto)
                                                <img src="{{ Storage::url($indicado->foto) }}" 
                                                     alt="{{ $indicado->nome }}" 
                                                     class="rounded-circle me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover; border: 2px solid {{ $indicado->id == $vencedor->indicado_id ? '#D4AF37' : '#666' }};">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 50px; height: 50px; border: 2px solid {{ $indicado->id == $vencedor->indicado_id ? '#D4AF37' : '#666' }};">
                                                    <i class="bi bi-person-fill text-white"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 {{ $indicado->id == $vencedor->indicado_id ? 'text-gold' : 'text-white' }}">
                                                    {{ $indicado->nome }}
                                                    @if($indicado->id == $vencedor->indicado_id)
                                                        <i class="bi bi-star-fill text-gold ms-1"></i>
                                                    @endif
                                                </h6>
                                                @if($indicado->descricao)
                                                    <small class="text-muted">{{ $indicado->descricao }}</small>
                                                @endif
                                            </div>
                                            
                                            <div class="text-end" style="min-width: 120px;">
                                                <div class="fw-bold {{ $indicado->id == $vencedor->indicado_id ? 'text-gold' : 'text-white' }}" style="font-size: 1.2rem;">
                                                    {{ $indicado->porcentagem }}%
                                                </div>
                                                <small class="text-muted">{{ $indicado->total_votos }} voto{{ $indicado->total_votos != 1 ? 's' : '' }}</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Barra de progresso -->
                                        <div class="progress mt-3" style="height: 10px; background: #1a1a1a;">
                                            <div class="progress-bar" 
                                                 style="background: {{ $indicado->id == $vencedor->indicado_id ? 'linear-gradient(90deg, #D4AF37, #FFD700)' : '#6c757d' }}; width: {{ $indicado->porcentagem }}%;">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #D4AF37;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i>Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endif

@endsection
