@extends('layouts.admin')

@section('page-title', 'Categorias')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
    <h5 class="mb-0">Todas as Categorias</h5>
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova Categoria
    </a>
</div>

<!-- Lista de Categorias em Cards -->
<div class="row g-3">
    @forelse($categorias as $categoria)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="text-gold mb-0">{{ $categoria->nome }}</h6>
                        <span class="badge bg-secondary">{{ $categoria->edicao->ano }}</span>
                    </div>
                    
                    @if($categoria->descricao)
                        <p class="text-muted small mb-2">{{ Str::limit($categoria->descricao, 60) }}</p>
                    @endif
                    
                    <div class="d-flex gap-3 mb-3 text-muted small">
                        <span><i class="bi bi-people me-1"></i>{{ $categoria->indicados_count }} indicados</span>
                        <span><i class="bi bi-sort-numeric-down me-1"></i>Ordem: {{ $categoria->ordem }}</span>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.categorias.show', $categoria) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza? Todos os indicados e votos desta categoria serão excluídos.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-award fs-1 d-block mb-3"></i>
                    Nenhuma categoria cadastrada
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
