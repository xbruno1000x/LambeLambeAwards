@extends('layouts.admin')

@section('page-title', 'Votos')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
    <h5 class="mb-0">Histórico de Votos</h5>
    <a href="{{ route('admin.votos.resultados') }}" class="btn btn-primary">
        <i class="bi bi-bar-chart me-1"></i>Ver Resultados
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.votos.index') }}" method="GET" class="row g-3">
            <div class="col-12 col-md-4">
                <label for="edicao_id" class="form-label">Filtrar por Edição</label>
                <select class="form-select" id="edicao_id" name="edicao_id" onchange="this.form.submit()">
                    <option value="">Todas as edições</option>
                    @foreach($edicoes as $edicao)
                        <option value="{{ $edicao->id }}" {{ $edicaoId == $edicao->id ? 'selected' : '' }}>
                            {{ $edicao->ano }}{{ $edicao->titulo ? ' - ' . $edicao->titulo : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($categorias->count() > 0)
                <div class="col-12 col-md-4">
                    <label for="categoria_id" class="form-label">Filtrar por Categoria</label>
                    <select class="form-select" id="categoria_id" name="categoria_id" onchange="this.form.submit()">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $categoriaId == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Lista de Votos em Cards -->
<div class="row g-3">
    @forelse($votos as $voto)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary text-dark">{{ $voto->categoria->nome }}</span>
                        <small class="text-muted">{{ $voto->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <h6 class="mb-2">{{ $voto->indicado->nome }}</h6>
                    <small class="text-muted d-block">
                        <i class="bi bi-geo-alt me-1"></i>{{ $voto->ip_address }}
                    </small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    Nenhum voto registrado
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($votos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $votos->withQueryString()->links() }}
    </div>
@endif
@endsection
