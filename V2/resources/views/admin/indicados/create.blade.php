@extends('layouts.admin')

@section('page-title', 'Novo Indicado')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Adicionar Novo Indicado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.indicados.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                        <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                id="categoria_id" 
                                name="categoria_id" 
                                required>
                            <option value="">Selecione uma categoria</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome }} ({{ $categoria->edicao->ano }})
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome') }}" 
                               placeholder="Nome do indicado"
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
                                  placeholder="Uma breve descrição ou motivo da indicação...">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (opcional)</label>
                        <input type="file" 
                               class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" 
                               name="foto" 
                               accept="image/*">
                        <small class="text-muted">Formatos aceitos: JPG, PNG, GIF. Máx: 2MB</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Adicionar Indicado
                        </button>
                        <a href="{{ route('admin.indicados.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
