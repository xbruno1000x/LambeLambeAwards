@extends('layouts.admin')

@section('page-title', 'Editar Categoria')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Categoria</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
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
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição (opcional)</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" 
                                  name="descricao" 
                                  rows="3">{{ old('descricao', $categoria->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
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
</div>
@endsection
