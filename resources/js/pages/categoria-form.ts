/**
 * Script para os formulários de categoria (criar/editar)
 * Gerencia a adição dinâmica de indicados
 */

let contadorIndicados = 0;

/**
 * Adiciona um novo indicado ao formulário
 */
export function adicionarIndicado(nome: string = '', descricao: string = '', indicadoExistenteId: string = ''): void {
    contadorIndicados++;
    
    const html = `
        <div class="card bg-dark mb-2 indicado-item" id="indicado-${contadorIndicados}">
            <div class="card-body py-2 px-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][nome]" 
                               value="${escapeHtml(nome)}"
                               placeholder="Nome do indicado" 
                               required>
                        <input type="hidden" 
                               name="indicados[${contadorIndicados}][indicado_existente_id]" 
                               value="${escapeHtml(indicadoExistenteId)}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][descricao]" 
                               value="${escapeHtml(descricao)}"
                               placeholder="Descrição (opcional)">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remover-indicado" data-indicado-id="${contadorIndicados}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const listaIndicados = document.getElementById('listaIndicados');
    if (listaIndicados) {
        listaIndicados.insertAdjacentHTML('beforeend', html);
    }
    
    const semIndicados = document.getElementById('semIndicados');
    if (semIndicados) {
        semIndicados.style.display = 'none';
    }
    
    // Adicionar event listener ao novo botão de remover
    const novoBtn = document.querySelector(`#indicado-${contadorIndicados} .btn-remover-indicado`) as HTMLButtonElement;
    if (novoBtn) {
        novoBtn.addEventListener('click', () => removerIndicado(contadorIndicados));
    }
}

/**
 * Remove um indicado do formulário
 */
export function removerIndicado(id: number): void {
    const elemento = document.getElementById(`indicado-${id}`);
    if (elemento) {
        elemento.remove();
    }
    
    verificarIndicados();
}

/**
 * Remove um novo indicado (usado na página de edição)
 */
export function removerNovoIndicado(id: number): void {
    const elemento = document.getElementById(`indicado-novo-${id}`);
    if (elemento) {
        elemento.remove();
    }
    
    verificarIndicados();
}

/**
 * Marca um indicado existente para remoção (toggle)
 */
export function marcarRemover(id: number): void {
    const elemento = document.getElementById(`indicado-existente-${id}`);
    const inputRemover = document.getElementById(`remover-${id}`) as HTMLInputElement;
    
    if (!elemento || !inputRemover) return;
    
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

/**
 * Verifica se há indicados e mostra/esconde mensagem
 */
function verificarIndicados(): void {
    const semIndicados = document.getElementById('semIndicados');
    const indicadosItems = document.querySelectorAll('.indicado-item');
    
    if (semIndicados) {
        semIndicados.style.display = indicadosItems.length === 0 ? 'block' : 'none';
    }
}

/**
 * Escapa HTML para prevenir XSS
 */
function escapeHtml(text: string): string {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Inicializa o formulário de criação de categoria
 */
export function initCategoriaCreate(): void {
    const btnAdicionar = document.getElementById('btnAdicionarIndicado');
    if (btnAdicionar) {
        btnAdicionar.addEventListener('click', () => adicionarIndicado());
    }
    
    // Adicionar indicado existente ao clicar no botão
    document.querySelectorAll<HTMLButtonElement>('.btn-indicado-existente').forEach((btn) => {
        btn.addEventListener('click', () => {
            const nome = btn.dataset.nome || '';
            const id = btn.dataset.id || '';
            adicionarIndicado(nome, '', id);
        });
    });
}

/**
 * Inicializa o formulário de edição de categoria
 */
export function initCategoriaEdit(initialCount: number): void {
    contadorIndicados = initialCount;
    
    const btnAdicionar = document.getElementById('btnAdicionarIndicado');
    if (btnAdicionar) {
        btnAdicionar.addEventListener('click', () => adicionarIndicadoEdit());
    }
    
    // Adicionar indicado existente ao clicar no botão
    document.querySelectorAll<HTMLButtonElement>('.btn-indicado-existente').forEach((btn) => {
        btn.addEventListener('click', () => {
            const nome = btn.dataset.nome || '';
            adicionarIndicadoEdit(nome, '');
        });
    });
    
    // Adicionar event listeners aos botões de marcar para remover
    document.querySelectorAll<HTMLButtonElement>('[onclick^="marcarRemover"]').forEach((btn) => {
        const onclickAttr = btn.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/marcarRemover\((\d+)\)/);
            if (match) {
                const id = parseInt(match[1], 10);
                btn.removeAttribute('onclick');
                btn.addEventListener('click', () => marcarRemover(id));
            }
        }
    });
}

/**
 * Adiciona um indicado no formulário de edição
 */
function adicionarIndicadoEdit(nome: string = '', descricao: string = ''): void {
    contadorIndicados++;
    
    const html = `
        <div class="card bg-dark mb-2 indicado-item" id="indicado-novo-${contadorIndicados}">
            <div class="card-body py-2 px-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][nome]" 
                               value="${escapeHtml(nome)}"
                               placeholder="Nome do indicado" 
                               required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="indicados[${contadorIndicados}][descricao]" 
                               value="${escapeHtml(descricao)}"
                               placeholder="Descrição (opcional)">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remover-novo" data-indicado-id="${contadorIndicados}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const listaIndicados = document.getElementById('listaIndicados');
    if (listaIndicados) {
        listaIndicados.insertAdjacentHTML('beforeend', html);
    }
    
    const semIndicados = document.getElementById('semIndicados');
    if (semIndicados) {
        semIndicados.style.display = 'none';
    }
    
    // Adicionar event listener ao novo botão de remover
    const novoBtn = document.querySelector(`#indicado-novo-${contadorIndicados} .btn-remover-novo`) as HTMLButtonElement;
    if (novoBtn) {
        novoBtn.addEventListener('click', () => removerNovoIndicado(contadorIndicados));
    }
}

// Expor funções globalmente para compatibilidade com onclick inline (será removido gradualmente)
declare global {
    interface Window {
        adicionarIndicado: typeof adicionarIndicado;
        removerIndicado: typeof removerIndicado;
        removerNovoIndicado: typeof removerNovoIndicado;
        marcarRemover: typeof marcarRemover;
        initCategoriaCreate: typeof initCategoriaCreate;
        initCategoriaEdit: typeof initCategoriaEdit;
    }
}

window.adicionarIndicado = adicionarIndicado;
window.removerIndicado = removerIndicado;
window.removerNovoIndicado = removerNovoIndicado;
window.marcarRemover = marcarRemover;
window.initCategoriaCreate = initCategoriaCreate;
window.initCategoriaEdit = initCategoriaEdit;
