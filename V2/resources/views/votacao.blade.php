@extends('layouts.app')

@section('title', 'Votação - Lambe Lambe Awards')

@section('content')
<div style="background-image: url('{{ asset('images/fundo.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.85);"></div>
    <div class="container py-5" style="position: relative; z-index: 1;">
        <h2 class="section-title">Votação</h2>
    
    <!-- Alert para feedback via AJAX -->
    <div id="alertContainer"></div>
    
    @if(isset($message))
        <div class="text-center py-5">
            <i class="bi bi-info-circle fs-1 text-gold mb-3 d-block"></i>
            <p class="text-muted fs-5">{{ $message }}</p>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">Voltar ao Início</a>
        </div>
    @elseif($edicaoAtiva && $edicaoAtiva->categorias->count() > 0)
        <div class="text-center mb-4">
            <span class="badge bg-primary text-dark fs-6 px-3 py-2">
                Edição {{ $edicaoAtiva->ano }}
                @if($edicaoAtiva->titulo)
                    - {{ $edicaoAtiva->titulo }}
                @endif
            </span>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @foreach($edicaoAtiva->categorias as $categoria)
                    <div class="card categoria-card mb-4" id="categoria-{{ $categoria->id }}">
                        <div class="categoria-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><i class="bi bi-award me-2"></i>{{ $categoria->nome }}</h3>
                            <span class="voted-badge" id="voted-badge-{{ $categoria->id }}" style="display: none;">
                                <i class="bi bi-check-circle me-1"></i>Votado
                            </span>
                        </div>
                        <div class="card-body">
                            @if($categoria->descricao)
                                <p class="text-muted mb-3">{{ $categoria->descricao }}</p>
                            @endif
                            
                            <form class="form-votacao" data-categoria-id="{{ $categoria->id }}">
                                @csrf
                                <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">
                                
                                @forelse($categoria->indicados as $indicado)
                                    <label class="vote-option d-block">
                                        <input type="radio" name="indicado_id" value="{{ $indicado->id }}" required>
                                        <span class="vote-label">
                                            @if($indicado->foto)
                                                <img src="{{ Storage::url($indicado->foto) }}" alt="{{ $indicado->nome }}" class="indicado-foto" style="width: 50px; height: 50px;">
                                            @endif
                                            <span>
                                                {{ $indicado->nome }}
                                                @if($indicado->descricao)
                                                    <small class="d-block text-muted">{{ $indicado->descricao }}</small>
                                                @endif
                                            </span>
                                        </span>
                                    </label>
                                @empty
                                    <div class="text-center py-3 text-muted">
                                        Nenhum indicado nesta categoria
                                    </div>
                                @endforelse
                                
                                @if($categoria->indicados->count() > 0)
                                    <button type="submit" class="btn btn-primary w-100 mt-3">
                                        <i class="bi bi-check2-circle me-2"></i>Confirmar Voto
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-emoji-neutral fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">Nenhuma categoria disponível para votação.</p>
        </div>
    @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.form-votacao');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const categoriaId = this.dataset.categoriaId;
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Verificar se um indicado foi selecionado
            const indicadoSelecionado = this.querySelector('input[name="indicado_id"]:checked');
            if (!indicadoSelecionado) {
                mostrarAlert('danger', 'Por favor, selecione um indicado antes de votar.');
                return;
            }
            
            // Desabilitar botão durante o envio
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Enviando...';
            
            fetch('{{ route("votacao.votar") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar badge de votado
                    const badge = document.getElementById('voted-badge-' + categoriaId);
                    if (badge) {
                        badge.style.display = 'inline-flex';
                        // Esconder após 3 segundos
                        setTimeout(() => {
                            badge.style.display = 'none';
                        }, 3000);
                    }
                    
                    // Desmarcar apenas os radio buttons desta categoria
                    const radios = form.querySelectorAll('input[type="radio"]');
                    radios.forEach(radio => radio.checked = false);
                    
                    // Mostrar mensagem de sucesso
                    mostrarAlert('success', data.message || 'Voto registrado com sucesso!');
                } else {
                    mostrarAlert('danger', data.message || 'Erro ao registrar voto.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarAlert('danger', 'Erro ao enviar voto. Tente novamente.');
            })
            .finally(() => {
                // Reabilitar botão
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    });
    
    function mostrarAlert(tipo, mensagem) {
        const container = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const alertHtml = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert" id="${alertId}">
                <i class="bi bi-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-remover após 4 segundos
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.remove();
            }
        }, 4000);
    }
});
</script>
@endpush
@endsection
