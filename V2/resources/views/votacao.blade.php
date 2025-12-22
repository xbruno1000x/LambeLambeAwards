@extends('layouts.app')

@section('title', 'Votação - Lambe Lambe Awards')

@section('content')
<div style="background-image: url('{{ asset('images/fundo.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.85);"></div>
    <div class="container py-5" style="position: relative; z-index: 1;">
        <h2 class="section-title">Votação</h2>
    
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
    
    @if(isset($message))
        <div class="text-center py-5">
            <i class="bi bi-info-circle fs-1 text-gold mb-3 d-block"></i>
            <p class="text-muted fs-5">{{ $message }}</p>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">Voltar ao Início</a>
        </div>
    @elseif($edicaoAtiva && $edicaoAtiva->categorias->count() > 0)
        <div class="text-center mb-4">
            <span class="badge bg-primary text-dark fs-6 px-3 py-2">
                Edição {{ $edicaoAtiva->ano }}
                @if($edicaoAtiva->titulo)
                    - {{ $edicaoAtiva->titulo }}
                @endif
            </span>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @foreach($edicaoAtiva->categorias as $categoria)
                    <div class="card categoria-card mb-4">
                        <div class="categoria-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><i class="bi bi-award me-2"></i>{{ $categoria->nome }}</h3>
                            @if(in_array($categoria->id, $categoriasVotadas ?? []))
                                <span class="voted-badge">
                                    <i class="bi bi-check-circle me-1"></i>Votado
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($categoria->descricao)
                                <p class="text-muted mb-3">{{ $categoria->descricao }}</p>
                            @endif
                            
                            @if(in_array($categoria->id, $categoriasVotadas ?? []))
                                <div class="text-center py-3">
                                    <i class="bi bi-check-circle-fill text-success fs-3 mb-2 d-block"></i>
                                    <p class="text-muted mb-0">Você já votou nesta categoria!</p>
                                </div>
                            @else
                                <form action="{{ route('votacao.votar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">
                                    
                                    @forelse($categoria->indicados as $indicado)
                                        <label class="vote-option d-block">
                                            <input type="radio" name="indicado_id" value="{{ $indicado->id }}" required>
                                            <span class="vote-label">
                                                @if($indicado->foto)
                                                    <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="indicado-foto" style="width: 50px; height: 50px;">
                                                @endif
                                                <span>
                                                    {{ $indicado->nome }}
                                                    @if($indicado->descricao)
                                                        <small class="d-block text-muted">{{ $indicado->descricao }}</small>
                                                    @endif
                                                </span>
                                            </span>
                                        </label>
                                    @empty
                                        <div class="text-center py-3 text-muted">
                                            Nenhum indicado nesta categoria
                                        </div>
                                    @endforelse
                                    
                                    @if($categoria->indicados->count() > 0)
                                        <button type="submit" class="btn btn-primary w-100 mt-3">
                                            <i class="bi bi-check2-circle me-2"></i>Confirmar Voto
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-emoji-neutral fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">Nenhuma categoria disponível para votação.</p>
        </div>
    @endif
    </div>
</div>
@endsection
