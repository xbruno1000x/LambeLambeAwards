@extends('layouts.admin')

@section('page-title', 'Edições')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
    <h5 class="mb-0">Todas as Edições</h5>
    <a href="{{ route('admin.edicoes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova Edição
    </a>
</div>

<!-- Lista de Edições em Cards -->
<div class="row g-3">
    @forelse($edicoes as $edicao)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="text-gold mb-0">{{ $edicao->ano }}</h5>
                        <div class="d-flex gap-1">
                            @if($edicao->ativa)
                                <span class="badge bg-success">Ativa</span>
                            @else
                                <span class="badge bg-secondary">Inativa</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($edicao->titulo)
                        <p class="mb-2">{{ $edicao->titulo }}</p>
                    @endif
                    
                    <div class="d-flex gap-3 mb-3 text-muted small">
                        <span><i class="bi bi-award me-1"></i>{{ $edicao->categorias_count }} categorias</span>
                        <span>
                            <i class="bi bi-{{ $edicao->votacao_aberta ? 'unlock' : 'lock' }} me-1"></i>
                            Votação {{ $edicao->votacao_aberta ? 'Aberta' : 'Fechada' }}
                        </span>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.edicoes.show', $edicao) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.edicoes.edit', $edicao) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.edicoes.toggle-ativa', $edicao) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-{{ $edicao->ativa ? 'warning' : 'success' }}" title="{{ $edicao->ativa ? 'Desativar' : 'Ativar' }}">
                                <i class="bi bi-{{ $edicao->ativa ? 'toggle-on' : 'toggle-off' }}"></i>
                            </button>
                        </form>
                        @if($edicao->vencedores_count == 0)
                            <form action="{{ route('admin.edicoes.destroy', $edicao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta edição?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                    Nenhuma edição cadastrada
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
