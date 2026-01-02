@extends('layouts.admin')

@section('page-title', 'Editar Categoria')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Categoria</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edicao_id" class="form-label">Edição <span class="text-danger">*</span></label>
                            <select class="form-select @error('edicao_id') is-invalid @enderror" 
                                    id="edicao_id" 
                                    name="edicao_id" 
                                    required>
                                <option value="">Selecione uma edição</option>
                                @foreach($edicoes as $edicao)
                                    <option value="{{ $edicao->id }}" {{ old('edicao_id', $categoria->edicao_id) == $edicao->id ? 'selected' : '' }}>
                                        {{ $edicao->ano }}{{ $edicao->titulo ? ' - ' . $edicao->titulo : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('edicao_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="ordem" class="form-label">Ordem de exibição</label>
                            <input type="number" 
                                   class="form-control @error('ordem') is-invalid @enderror" 
                                   id="ordem" 
                                   name="ordem" 
                                   value="{{ old('ordem', $categoria->ordem) }}" 
                                   min="0">
                            @error('ordem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome', $categoria->nome) }}" 
                               required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="descricao" class="form-label">Descrição (opcional)</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" 
                                  name="descricao" 
                                  rows="2">{{ old('descricao', $categoria->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Seção de Indicados -->
                    <hr class="border-gold">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-gold mb-0"><i class="bi bi-people me-2"></i>Indicados</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnAdicionarIndicado">
                            <i class="bi bi-plus me-1"></i>Adicionar Indicado
                        </button>
                    </div>
                    
                    <div id="listaIndicados">
                        @foreach($categoria->indicados as $index => $indicado)
                            <div class="card bg-dark mb-2 indicado-item" id="indicado-existente-{{ $indicado->id }}">
                                <div class="card-body py-2 px-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <input type="hidden" name="indicados[{{ $index }}][id]" value="{{ $indicado->id }}">
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   name="indicados[{{ $index }}][nome]" 
                                                   value="{{ $indicado->nome }}"
                                                   placeholder="Nome do indicado" 
                                                   required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   name="indicados[{{ $index }}][descricao]" 
                                                   value="{{ $indicado->descricao }}"
                                                   placeholder="Descrição (opcional)">
                                        </div>
                                        <div class="col-md-2">
                                            <span class="badge bg-secondary">{{ $indicado->votos->count() }} votos</span>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="marcarRemover({{ $indicado->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <input type="hidden" name="indicados[{{ $index }}][remover]" id="remover-{{ $indicado->id }}" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($categoria->indicados->count() == 0)
                        <div class="text-muted small mb-4" id="semIndicados">
                            <i class="bi bi-info-circle me-1"></i>
                            Esta categoria não possui indicados.
                        </div>
                    @else
                        <div class="text-muted small mb-4" id="semIndicados" style="display: none;">
                            <i class="bi bi-info-circle me-1"></i>
                            Esta categoria não possui indicados.
                        </div>
                    @endif
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Salvar Alterações
                        </button>
                        <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Painel lateral -->
    <div class="col-lg-4">
        <!-- Lista de indicados existentes para referência -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-person-check me-2"></i>Adicionar Indicado Existente</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <p class="text-muted small mb-2">Clique para adicionar à categoria:</p>
                <div class="d-flex flex-wrap gap-1">
                    @foreach($indicadosExistentes as $indicadoExistente)
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary btn-indicado-existente"
                                data-nome="{{ $indicadoExistente->nome }}"
                                data-id="{{ $indicadoExistente->id }}">
                            {{ $indicadoExistente->nome }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let contadorIndicados = {{ $categoria->indicados->count() }};

function adicionarIndicado(nome = '', descricao = '') {
    contadorIndicados++;
    const html = `
        <div class="card bg-dark mb-2 indicado-item" id="indicado-novo-${contadorIndicados}">
            <div class="card-body py-2 px-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][nome]" 
                               value="${nome}"
                               placeholder="Nome do indicado" 
                               required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][descricao]" 
                               value="${descricao}"
                               placeholder="Descrição (opcional)">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerNovoIndicado(${contadorIndicados})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('listaIndicados').insertAdjacentHTML('beforeend', html);
    document.getElementById('semIndicados').style.display = 'none';
}

function removerNovoIndicado(id) {
    const elemento = document.getElementById(`indicado-novo-${id}`);
    if (elemento) {
        elemento.remove();
    }
    verificarIndicados();
}

function marcarRemover(id) {
    const elemento = document.getElementById(`indicado-existente-${id}`);
    const inputRemover = document.getElementById(`remover-${id}`);
    
    if (inputRemover.value === '0') {
        inputRemover.value = '1';
        elemento.style.opacity = '0.5';
        elemento.style.textDecoration = 'line-through';
    } else {
        inputRemover.value = '0';
        elemento.style.opacity = '1';
        elemento.style.textDecoration = 'none';
    }
}

function verificarIndicados() {
    if (document.querySelectorAll('.indicado-item').length === 0) {
        document.getElementById('semIndicados').style.display = 'block';
    }
}

document.getElementById('btnAdicionarIndicado').addEventListener('click', function() {
    adicionarIndicado();
});

// Adicionar indicado existente ao clicar no botão
document.querySelectorAll('.btn-indicado-existente').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const nome = this.dataset.nome;
        adicionarIndicado(nome, '');
    });
});
</script>
@endpush
@endsection
