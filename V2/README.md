# 🏆 Lambe Lambe Awards V2.0

Uma paródia bem-humorada do Oscar, criada para celebrar (e zoar) os momentos mais marcantes entre amigos ao longo do ano.

## 🎨 Design

- **Paleta de cores:** Preto e Dourado
- **Framework CSS:** Bootstrap 5 com SCSS customizado
- **Tipografia:** Cinzel & Cinzel Decorative

## 🛠️ Tecnologias

- **Backend:** Laravel 12
- **Frontend:** Bootstrap 5, SCSS, Vite
- **Banco de Dados:** MySQL
- **Ícones:** Bootstrap Icons

## 📋 Funcionalidades

### Área Pública
- **Início:** Página principal com informações da edição ativa
- **Indicados:** Lista de todas as categorias e indicados da edição atual
- **Votação:** Sistema de votação confiável com controle de fraude
  - Token único por votante (cookie)
  - Limite de 1 voto por categoria por pessoa
  - Registro de IP e User-Agent
- **Vencedores:** Histórico de vencedores de edições anteriores
- **Sobre:** Informações sobre o prêmio

### Painel Administrativo
- **Dashboard:** Visão geral com estatísticas
- **Edições:** Gerenciar edições do prêmio (criar, editar, ativar/desativar)
- **Categorias:** Gerenciar categorias por edição
- **Indicados:** Cadastrar indicados com foto e descrição
- **Votos:** Visualizar histórico de votos
- **Resultados:** Ver apuração em tempo real
- **Finalizar Votação:** Calcular e registrar vencedores automaticamente

## 🚀 Instalação

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8+

### Passos

1. **Clone o repositório** (ou navegue até a pasta V2)
```bash
cd V2
```

2. **Instale as dependências PHP**
```bash
composer install
```

3. **Instale as dependências NPM**
```bash
npm install
```

4. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o banco de dados no `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lambe_lambe_v2
DB_USERNAME=root
DB_PASSWORD=
```

6. **Crie o banco de dados**
```sql
CREATE DATABASE lambe_lambe_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

7. **Execute as migrations e seeders**
```bash
php artisan migrate --seed
```

8. **Crie o link do storage**
```bash
php artisan storage:link
```

9. **Compile os assets**
```bash
npm run build
```

10. **Inicie o servidor**
```bash
php artisan serve
```

## 🔐 Acesso ao Painel Administrativo

- **URL:** http://localhost:8000/admin/login
- **E-mail:** admin@lambelambe.com
- **Senha:** admin123

⚠️ **Importante:** Altere a senha após o primeiro acesso!

## 📝 Como Usar

### 1. Criar uma Edição
1. Acesse o painel admin
2. Vá em "Edições" > "Nova Edição"
3. Informe o ano e título (opcional)
4. Ative a edição (apenas uma pode estar ativa)

### 2. Criar Categorias
1. Vá em "Categorias" > "Nova Categoria"
2. Selecione a edição
3. Defina nome, descrição e ordem

### 3. Cadastrar Indicados
1. Vá em "Indicados" > "Novo Indicado"
2. Selecione a categoria
3. Adicione nome, descrição e foto (opcional)

### 4. Abrir Votação
1. Na edição ativa, clique em "Abrir Votação"
2. Compartilhe o link da votação com os amigos

### 5. Encerrar e Ver Resultados
1. Clique em "Fechar Votação"
2. Clique em "Finalizar e Calcular Vencedores"
3. Os resultados aparecerão na página de Vencedores

## 🔒 Segurança da Votação

O sistema implementa várias medidas anti-fraude:

- **Token único:** Cada votante recebe um UUID único armazenado em cookie
- **Limite por categoria:** Apenas 1 voto por categoria por token
- **Registro de dados:** IP e User-Agent são registrados
- **Validação server-side:** Todas as verificações são feitas no backend

## 📁 Estrutura de Pastas

```
V2/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/         # Controllers do painel admin
│   │   ├── HomeController.php
│   │   ├── VotacaoController.php
│   │   └── VencedorController.php
│   └── Models/            # Eloquent Models
├── database/
│   ├── migrations/        # Estrutura do banco
│   └── seeders/           # Dados iniciais
├── resources/
│   ├── scss/app.scss      # Estilos customizados
│   └── views/             # Templates Blade
└── routes/web.php         # Rotas da aplicação
```

---

Desenvolvido com ❤️ para os Lambe Lambe Awards
