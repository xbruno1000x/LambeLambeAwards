@extends('layouts.admin')

@section('page-title', 'Indicados')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
    <h5 class="mb-0">Todos os Indicados</h5>
    <a href="{{ route('admin.indicados.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Novo Indicado
    </a>
</div>

<!-- Lista de Indicados em Cards -->
<div class="row g-3">
    @forelse($indicados as $indicado)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($indicado->foto)
                            <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-person-fill text-gold fs-2"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h6 class="mb-1">{{ $indicado->nome }}</h6>
                    <p class="text-gold small mb-1">{{ $indicado->categoria->nome }}</p>
                    <p class="text-muted small mb-3">Edição {{ $indicado->categoria->edicao->ano }}</p>
                    
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.indicados.show', $indicado) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.indicados.edit', $indicado) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.indicados.destroy', $indicado) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza? Todos os votos deste indicado serão excluídos.')">
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
                    <i class="bi bi-people fs-1 d-block mb-3"></i>
                    Nenhum indicado cadastrado
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
