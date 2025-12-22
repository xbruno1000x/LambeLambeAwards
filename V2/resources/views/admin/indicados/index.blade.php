@extends('layouts.admin')

@section('page-title', 'Indicados')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Todos os Indicados</h5>
    <a href="{{ route('admin.indicados.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Novo Indicado
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Edição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($indicados as $indicado)
                        <tr>
                            <td>
                                @if($indicado->foto)
                                    <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill text-gold"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $indicado->nome }}</td>
                            <td class="text-gold">{{ $indicado->categoria->nome }}</td>
                            <td>{{ $indicado->categoria->edicao->ano }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.indicados.show', $indicado) }}" class="btn btn-outline-primary" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.indicados.edit', $indicado) }}" class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.indicados.destroy', $indicado) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza? Todos os votos deste indicado serão excluídos.')">
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
                                Nenhum indicado cadastrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
