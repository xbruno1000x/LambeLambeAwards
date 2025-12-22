@extends('layouts.admin')

@section('page-title', 'Edições')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Todas as Edições</h5>
    <a href="{{ route('admin.edicoes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova Edição
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Ano</th>
                        <th>Título</th>
                        <th>Categorias</th>
                        <th>Status</th>
                        <th>Votação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($edicoes as $edicao)
                        <tr>
                            <td class="fw-bold text-gold">{{ $edicao->ano }}</td>
                            <td>{{ $edicao->titulo ?? '-' }}</td>
                            <td>{{ $edicao->categorias_count }} categorias</td>
                            <td>
                                @if($edicao->ativa)
                                    <span class="badge bg-success">Ativa</span>
                                @else
                                    <span class="badge bg-secondary">Inativa</span>
                                @endif
                            </td>
                            <td>
                                @if($edicao->votacao_aberta)
                                    <span class="badge bg-success">Aberta</span>
                                @else
                                    <span class="badge bg-secondary">Fechada</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.edicoes.show', $edicao) }}" class="btn btn-outline-primary" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.edicoes.edit', $edicao) }}" class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.edicoes.toggle-ativa', $edicao) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-{{ $edicao->ativa ? 'warning' : 'success' }}" title="{{ $edicao->ativa ? 'Desativar' : 'Ativar' }}">
                                            <i class="bi bi-{{ $edicao->ativa ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    @if($edicao->vencedores_count == 0)
                                        <form action="{{ route('admin.edicoes.destroy', $edicao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta edição?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Nenhuma edição cadastrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
