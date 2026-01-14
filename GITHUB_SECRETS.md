# Configuração de GitHub Secrets

Para o deploy funcionar corretamente, você precisa configurar os seguintes secrets no seu repositório do GitHub:

## Como configurar:

1. Acesse seu repositório no GitHub
2. Vá em **Settings** > **Secrets and variables** > **Actions**
3. Clique em **New repository secret** para cada secret abaixo

## Secrets necessários:

| Secret Name | Descrição | Exemplo |
|-------------|-----------|---------|
| `FTP_USERNAME` | Usuário FTP do InfinityFree | `epiz_12345678` |
| `FTP_PASSWORD` | Senha FTP do InfinityFree | `sua_senha_ftp` |
| `APP_KEY` | Chave da aplicação Laravel | `base64:SuaChaveAqui...` |
| `APP_URL` | URL da aplicação em produção | `https://seusite.com/` |
| `DB_HOST` | Host do banco de dados | `sql100.infinityfree.com` |
| `DB_DATABASE` | Nome do banco de dados | `if0_12345678_seudb` |
| `DB_USERNAME` | Usuário do banco de dados | `if0_12345678` |
| `DB_PASSWORD` | Senha do banco de dados | `sua_senha_db` |

## Importante:

- **Nunca** commite credenciais reais no arquivo `.env`
- O arquivo `.env` está no `.gitignore` e não será enviado ao repositório
- O workflow de deploy gera automaticamente o `.env` em produção usando os secrets
- Use o arquivo `.env.example` como template para desenvolvimento local

## Gerando uma nova APP_KEY:

Se precisar gerar uma nova chave, execute:
```bash
php artisan key:generate --show
```

Copie o resultado e adicione como secret `APP_KEY`.
