@extends('layouts.admin')

@section('page-title', 'Nova Categoria')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Criar Nova Categoria</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categorias.store') }}" method="POST" id="formCategoria">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edicao_id" class="form-label">Edição <span class="text-danger">*</span></label>
                            <select class="form-select @error('edicao_id') is-invalid @enderror" 
                                    id="edicao_id" 
                                    name="edicao_id" 
                                    required>
                                <option value="">Selecione uma edição</option>
                                @foreach($edicoes as $edicao)
                                    <option value="{{ $edicao->id }}" {{ (old('edicao_id') ?? $edicaoSelecionada) == $edicao->id ? 'selected' : '' }}>
                                        {{ $edicao->ano }}{{ $edicao->titulo ? ' - ' . $edicao->titulo : '' }}
                                        @if($edicao->ativa) (Ativa) @endif
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
                                   value="{{ old('ordem', 0) }}" 
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
                               value="{{ old('nome') }}" 
                               placeholder="Ex: Maior babaca do ano"
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
                                  rows="2"
                                  placeholder="Descrição da categoria...">{{ old('descricao') }}</textarea>
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
                        <!-- Indicados serão adicionados aqui dinamicamente -->
                    </div>
                    
                    <div class="text-muted small mb-4" id="semIndicados">
                        <i class="bi bi-info-circle me-1"></i>
                        Clique em "Adicionar Indicado" para incluir os concorrentes desta categoria.
                        Você também pode reaproveitar indicados de outras edições.
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Criar Categoria
                        </button>
                        <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Painel lateral para copiar categoria -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-copy me-2"></i>Copiar de Edição Anterior</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categorias.duplicar') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="categoria_origem_id" class="form-label">Categoria a copiar</label>
                        <select class="form-select" id="categoria_origem_id" name="categoria_origem_id" required>
                            <option value="">Selecione...</option>
                            @foreach($categoriasAnteriores as $edicaoLabel => $categorias)
                                <optgroup label="{{ $edicaoLabel }}">
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edicao_destino_id" class="form-label">Para a edição</label>
                        <select class="form-select" id="edicao_destino_id" name="edicao_destino_id" required>
                            <option value="">Selecione...</option>
                            @foreach($edicoes as $edicao)
                                <option value="{{ $edicao->id }}">
                                    {{ $edicao->ano }}{{ $edicao->titulo ? ' - ' . $edicao->titulo : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="copiar_indicados" name="copiar_indicados" value="1" checked>
                        <label class="form-check-label" for="copiar_indicados">
                            Copiar indicados também
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-files me-1"></i>Duplicar Categoria
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Lista de indicados existentes para referência -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-person-check me-2"></i>Indicados Existentes</h6>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                <p class="text-muted small mb-2">Clique para adicionar à categoria:</p>
                <div class="d-flex flex-wrap gap-1">
                    @foreach($indicadosExistentes as $indicado)
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary btn-indicado-existente"
                                data-nome="{{ $indicado->nome }}"
                                data-id="{{ $indicado->id }}">
                            {{ $indicado->nome }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let contadorIndicados = 0;

function adicionarIndicado(nome = '', descricao = '', indicadoExistenteId = '') {
    contadorIndicados++;
    const html = `
        <div class="card bg-dark mb-2 indicado-item" id="indicado-${contadorIndicados}">
            <div class="card-body py-2 px-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][nome]" 
                               value="${nome}"
                               placeholder="Nome do indicado" 
                               required>
                        <input type="hidden" 
                               name="indicados[${contadorIndicados}][indicado_existente_id]" 
                               value="${indicadoExistenteId}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][descricao]" 
                               value="${descricao}"
                               placeholder="Descrição (opcional)">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerIndicado(${contadorIndicados})">
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

function removerIndicado(id) {
    const elemento = document.getElementById(`indicado-${id}`);
    if (elemento) {
        elemento.remove();
    }
    
    // Mostrar mensagem se não houver indicados
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
        const id = this.dataset.id;
        adicionarIndicado(nome, '', id);
    });
});
</script>
@endpush
@endsection
