@extends('layouts.admin')

@section('page-title', 'Nova Categoria')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Criar Nova Categoria</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categorias.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="edicao_id" class="form-label">Edição <span class="text-danger">*</span></label>
                        <select class="form-select @error('edicao_id') is-invalid @enderror" 
                                id="edicao_id" 
                                name="edicao_id" 
                                required>
                            <option value="">Selecione uma edição</option>
                            @foreach($edicoes as $edicao)
                                <option value="{{ $edicao->id }}" {{ old('edicao_id') == $edicao->id ? 'selected' : '' }}>
                                    {{ $edicao->ano }}{{ $edicao->titulo ? ' - ' . $edicao->titulo : '' }}
                                    @if($edicao->ativa) (Ativa) @endif
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
                               value="{{ old('nome') }}" 
                               placeholder="Ex: Melhor Amigo do Ano"
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
                                  rows="3"
                                  placeholder="Descrição da categoria...">{{ old('descricao') }}</textarea>
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
                               value="{{ old('ordem', 0) }}" 
                               min="0">
                        @error('ordem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
</div>
@endsection
