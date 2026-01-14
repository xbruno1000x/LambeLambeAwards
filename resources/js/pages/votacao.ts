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
declare const CAPTCHA_IMAGE_URL: string;

// Contador global de votos para captcha
let voteCount = 0;
const VOTES_BEFORE_CAPTCHA = 5;

// Resolver do captcha pendente
let captchaResolver: ((value: boolean) => void) | null = null;

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
 * Cria e exibe o modal de captcha
 */
function showCaptchaModal(captchaImageUrl: string): Promise<boolean> {
    return new Promise((resolve) => {
        captchaResolver = resolve;
        
        // Remover modal existente se houver
        const existingModal = document.getElementById('captchaModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Opções do captcha (emojis + imagem correta)
        const options = [
            { id: 'monkey', content: '🐵', isCorrect: false },
            { id: 'dog', content: '🐶', isCorrect: false },
            { id: 'wolf', content: '🐺', isCorrect: false },
            { id: 'lion', content: '🦁', isCorrect: false },
            { id: 'viado', content: `<img src="${captchaImageUrl}" alt="Opção" class="captcha-img">`, isCorrect: true }
        ];
        
        // Embaralhar as opções
        const shuffledOptions = options.sort(() => Math.random() - 0.5);
        
        const optionsHtml = shuffledOptions.map(opt => `
            <button type="button" class="captcha-option" data-correct="${opt.isCorrect}">
                ${opt.content}
            </button>
        `).join('');
        
        const modalHtml = `
            <div class="modal fade" id="captchaModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark border-gold">
                        <div class="modal-header border-gold">
                            <h5 class="modal-title text-gold">
                                <i class="bi bi-shield-check me-2"></i>Verificação
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <p class="mb-4 fs-5">Selecione o viado entre esses animais</p>
                            <div class="captcha-options">
                                ${optionsHtml}
                            </div>
                            <div id="captchaError" class="text-danger mt-3" style="display: none;">
                                <i class="bi bi-x-circle me-1"></i>Resposta incorreta. Tente novamente.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        const modalElement = document.getElementById('captchaModal');
        if (!modalElement) return;
        
        // Adicionar event listeners aos botões
        modalElement.querySelectorAll('.captcha-option').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const target = e.currentTarget as HTMLButtonElement;
                const isCorrect = target.dataset.correct === 'true';
                
                if (isCorrect) {
                    // Resposta correta - fechar modal e resolver
                    const modal = (window as any).bootstrap?.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                    modalElement.remove();
                    voteCount = 0; // Resetar contador
                    if (captchaResolver) {
                        captchaResolver(true);
                        captchaResolver = null;
                    }
                } else {
                    // Resposta incorreta - mostrar erro
                    const errorDiv = document.getElementById('captchaError');
                    if (errorDiv) {
                        errorDiv.style.display = 'block';
                    }
                    // Adicionar animação de shake
                    target.classList.add('shake');
                    setTimeout(() => target.classList.remove('shake'), 500);
                }
            });
        });
        
        // Mostrar modal
        const modal = new (window as any).bootstrap.Modal(modalElement);
        modal.show();
        
        // Se o modal for fechado sem resposta correta
        modalElement.addEventListener('hidden.bs.modal', () => {
            if (captchaResolver) {
                captchaResolver(false);
                captchaResolver = null;
            }
            modalElement.remove();
        });
    });
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
            
            // Verificar se precisa mostrar captcha
            voteCount++;
            if (voteCount >= VOTES_BEFORE_CAPTCHA) {
                const captchaImageUrl = typeof CAPTCHA_IMAGE_URL !== 'undefined' ? CAPTCHA_IMAGE_URL : '/captcha.png';
                const captchaPassed = await showCaptchaModal(captchaImageUrl);
                if (!captchaPassed) {
                    state.isSubmitting = false;
                    return;
                }
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
                    
                    // Feedback silencioso - apenas badge (sem alert para não atrapalhar a página)
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
