@extends('layouts.admin')

@section('page-title', 'Detalhes do Indicado')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person me-2"></i>{{ $indicado->nome }}</h5>
                <a href="{{ route('admin.indicados.edit', $indicado) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
            </div>
            <div class="card-body text-center">
                @if($indicado->foto)
                    <img src="{{ Storage::url($indicado->foto) }}" 
                         alt="{{ $indicado->nome }}" 
                         class="rounded-circle mb-4" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #D4AF37;">
                @else
                    <div class="mx-auto mb-4 rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                         style="width: 150px; height: 150px; border: 4px solid #D4AF37;">
                        <i class="bi bi-person-fill text-gold fs-1"></i>
                    </div>
                @endif
                
                <h3 class="text-gold">{{ $indicado->nome }}</h3>
                
                @if($indicado->descricao)
                    <p class="text-muted">{{ $indicado->descricao }}</p>
                @endif
                
                <hr class="my-4" style="border-color: rgba(212, 175, 55, 0.3);">
                
                <div class="row text-center">
                    <div class="col-6">
                        <small class="text-muted d-block">Categoria</small>
                        <span class="text-gold">{{ $indicado->categoria->nome }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Edição</small>
                        <span>{{ $indicado->categoria->edicao->ano }}</span>
                    </div>
                </div>
                
                <hr class="my-4" style="border-color: rgba(212, 175, 55, 0.3);">
                
                <div class="stat-card">
                    <div class="stat-number">{{ $indicado->votos->count() }}</div>
                    <div class="stat-label">Votos Recebidos</div>
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('admin.indicados.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>
</div>
@endsection
