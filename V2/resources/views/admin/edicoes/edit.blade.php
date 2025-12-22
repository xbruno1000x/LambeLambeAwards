@extends('layouts.admin')

@section('page-title', 'Editar Edição')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Edição</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.edicoes.update', $edicao) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('ano') is-invalid @enderror" 
                               id="ano" 
                               name="ano" 
                               value="{{ old('ano', $edicao->ano) }}" 
                               min="2000" 
                               max="2100" 
                               required>
                        @error('ano')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título (opcional)</label>
                        <input type="text" 
                               class="form-control @error('titulo') is-invalid @enderror" 
                               id="titulo" 
                               name="titulo" 
                               value="{{ old('titulo', $edicao->titulo) }}" 
                               placeholder="Ex: A Noite das Estrelas">
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Salvar Alterações
                        </button>
                        <a href="{{ route('admin.edicoes.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
