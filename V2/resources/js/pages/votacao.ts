/**
 * Script para a página de votação
 * Gerencia o envio de votos via AJAX com prevenção de cliques múltiplos
 */

interface FormState {
    isSubmitting: boolean;
}

interface VoteResponse {
    success: boolean;
    message?: string;
}

// Variável global para a URL de votação (definida no blade)
declare const VOTACAO_URL: string;

/**
 * Mostra um alerta Bootstrap na página
 */
function mostrarAlert(tipo: 'success' | 'danger', mensagem: string): void {
    const container = document.getElementById('alertContainer');
    if (!container) return;
    
    const alertId = 'alert-' + Date.now();
    
    const iconClass = tipo === 'success' ? 'check-circle' : 'exclamation-circle';
    const alertHtml = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert" id="${alertId}">
            <i class="bi bi-${iconClass} me-2"></i>${mensagem}
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

/**
 * Inicializa o sistema de votação
 */
export function initVotacao(votacaoUrl: string): void {
    const forms = document.querySelectorAll<HTMLFormElement>('.form-votacao');
    
    // Armazenar estados de envio para cada formulário
    const formStates = new Map<string, FormState>();
    
    forms.forEach((form) => {
        const categoriaId = form.dataset.categoriaId;
        if (!categoriaId) return;
        
        formStates.set(categoriaId, { isSubmitting: false });
        
        form.addEventListener('submit', async (e: Event) => {
            e.preventDefault();
            e.stopPropagation();
            
            const state = formStates.get(categoriaId);
            if (!state) return;
            
            // Prevenir envios múltiplos
            if (state.isSubmitting) {
                return;
            }
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector<HTMLButtonElement>('button[type="submit"]');
            if (!submitBtn) return;
            
            const originalBtnText = submitBtn.innerHTML;
            
            // Verificar se um indicado foi selecionado
            const indicadoSelecionado = form.querySelector<HTMLInputElement>('input[name="indicado_id"]:checked');
            if (!indicadoSelecionado) {
                mostrarAlert('danger', 'Por favor, selecione um indicado antes de votar.');
                return;
            }
            
            // Marcar como enviando
            state.isSubmitting = true;
            
            // Desabilitar botão e todos os inputs durante o envio
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Enviando...';
            
            const allInputs = form.querySelectorAll<HTMLInputElement>('input[type="radio"]');
            allInputs.forEach(input => input.disabled = true);
            
            try {
                const response = await fetch(votacaoUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data: VoteResponse = await response.json();
                
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
                    const radios = form.querySelectorAll<HTMLInputElement>('input[type="radio"]');
                    radios.forEach(radio => radio.checked = false);
                    
                    // Mostrar mensagem de sucesso
                    mostrarAlert('success', data.message || 'Voto registrado com sucesso!');
                } else {
                    mostrarAlert('danger', data.message || 'Erro ao registrar voto.');
                }
            } catch (error) {
                console.error('Erro:', error);
                mostrarAlert('danger', 'Erro ao enviar voto. Tente novamente.');
            } finally {
                // Reabilitar botão e inputs
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                allInputs.forEach(input => input.disabled = false);
                
                // Liberar estado após um pequeno delay para evitar cliques acidentais
                setTimeout(() => {
                    state.isSubmitting = false;
                }, 500);
            }
        });
    });
}

// Auto-inicialização se a variável global estiver definida
document.addEventListener('DOMContentLoaded', () => {
    if (typeof VOTACAO_URL !== 'undefined') {
        initVotacao(VOTACAO_URL);
    }
});
