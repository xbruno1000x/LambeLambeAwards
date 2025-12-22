@extends('layouts.admin')

@section('page-title', 'Votos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Histórico de Votos</h5>
    <a href="{{ route('admin.votos.resultados') }}" class="btn btn-primary">
        <i class="bi bi-bar-chart me-1"></i>Ver Resultados
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.votos.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
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
                <div class="col-md-4">
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

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Categoria</th>
                        <th>Indicado</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($votos as $voto)
                        <tr>
                            <td>{{ $voto->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="text-gold">{{ $voto->categoria->nome }}</td>
                            <td>{{ $voto->indicado->nome }}</td>
                            <td><small class="text-muted">{{ $voto->ip_address }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Nenhum voto registrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($votos->hasPages())
        <div class="card-footer">
            {{ $votos->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
