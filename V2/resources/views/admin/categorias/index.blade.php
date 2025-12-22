@extends('layouts.admin')

@section('page-title', 'Categorias')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Todas as Categorias</h5>
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova Categoria
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Edição</th>
                        <th>Indicados</th>
                        <th>Ordem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $categoria)
                        <tr>
                            <td class="fw-bold text-gold">{{ $categoria->nome }}</td>
                            <td>{{ $categoria->edicao->ano }}</td>
                            <td>{{ $categoria->indicados_count }} indicados</td>
                            <td>{{ $categoria->ordem }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.categorias.show', $categoria) }}" class="btn btn-outline-primary" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza? Todos os indicados e votos desta categoria serão excluídos.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Nenhuma categoria cadastrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
