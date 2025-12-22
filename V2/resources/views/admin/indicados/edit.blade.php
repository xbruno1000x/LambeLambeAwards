@extends('layouts.admin')

@section('page-title', 'Editar Indicado')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Indicado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.indicados.update', $indicado) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                        <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                id="categoria_id" 
                                name="categoria_id" 
                                required>
                            <option value="">Selecione uma categoria</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id', $indicado->categoria_id) == $categoria->id ? 'selected' : '' }}>
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
                               value="{{ old('nome', $indicado->nome) }}" 
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
                                  rows="3">{{ old('descricao', $indicado->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        @if($indicado->foto)
                            <div class="mb-2">
                                <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="rounded" style="max-width: 150px;">
                                <small class="d-block text-muted mt-1">Foto atual</small>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" 
                               name="foto" 
                               accept="image/*">
                        <small class="text-muted">Deixe vazio para manter a foto atual</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Salvar Alterações
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
