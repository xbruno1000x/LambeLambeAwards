@extends('layouts.app')

@section('title', 'Indicados - Lambe Lambe Awards')

@section('content')
<div style="background-image: url('{{ asset('images/fundo.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.85);"></div>
    <div class="container py-5" style="position: relative; z-index: 1;">
        <h2 class="section-title">Indicados</h2>
    
    @if($edicaoAtiva && $edicaoAtiva->categorias->count() > 0)
        <div class="text-center mb-4">
            <span class="badge bg-primary text-dark fs-6 px-3 py-2 edicao-badge">
                Edição {{ $edicaoAtiva->ano }}
                @if($edicaoAtiva->titulo)
                    - {{ $edicaoAtiva->titulo }}
                @endif
            </span>
        </div>
        
        <div class="row g-4">
            @foreach($edicaoAtiva->categorias as $categoria)
                <div class="col-lg-6">
                    <div class="card categoria-card h-100">
                        <div class="categoria-header">
                            <h3><i class="bi bi-award me-2"></i>{{ $categoria->nome }}</h3>
                            @if($categoria->descricao)
                                <p class="text-muted mb-0 mt-2">{{ $categoria->descricao }}</p>
                            @endif
                        </div>
                        <div class="card-body p-0">
                            @forelse($categoria->indicados as $indicado)
                                <div class="indicado-item">
                                    @if($indicado->foto)
                                        <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="indicado-foto">
                                    @else
                                        <div class="indicado-foto d-flex align-items-center justify-content-center bg-secondary">
                                            <i class="bi bi-person-fill text-gold"></i>
                                        </div>
                                    @endif
                                    <div class="indicado-nome">
                                        {{ $indicado->nome }}
                                        @if($indicado->descricao)
                                            <small class="d-block text-muted">{{ $indicado->descricao }}</small>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-info-circle me-2"></i>Nenhum indicado cadastrado
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-emoji-neutral fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">Nenhuma categoria disponível no momento.</p>
        </div>
    @endif
    </div>
</div>
@endsection
