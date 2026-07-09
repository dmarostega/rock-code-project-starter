# Guia mínimo de deploy

Este guia cobre o deploy manual mínimo do starter em produção. Ele serve como base para VPS, CloudPanel ou ambiente equivalente com PHP, Composer, Node.js, banco de dados e servidor web já configurados.

## 1. Pré-requisitos

- PHP 8.3 ou superior, conforme a restrição `^8.3` do `composer.json`.
- Extensões PHP exigidas pelo Laravel e pelas dependências do projeto.
- Composer instalado.
- Node.js e npm instalados para gerar os assets.
- Banco de dados de produção criado.
- Domínio apontando para o servidor.
- HTTPS configurado antes de liberar o acesso público.

## 2. Publicação do código

1. Envie a versão aprovada para o servidor.
2. Acesse a pasta da aplicação.
3. Instale dependências PHP sem pacotes de desenvolvimento:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
```

4. Instale dependências front-end e gere os assets:

```bash
npm ci
npm run build
```

5. Ajuste permissões para que o usuário do PHP consiga escrever em `storage` e `bootstrap/cache`.

Permissões dependem do usuário/grupo do servidor. Como referência, mantenha o código-fonte somente leitura para o processo web quando possível e libere escrita apenas em:

- `storage`;
- `bootstrap/cache`.

## 3. `.env` mínimo de produção

Crie o `.env` de produção a partir de `.env.example` e revise pelo menos estes valores:

```dotenv
APP_NAME="Nome do Produto"
APP_ENV=production
APP_KEY=base64:gere-uma-chave-com-artisan-key-generate
APP_DEBUG=false
APP_URL=https://seudominio.com
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_TIMEZONE=America/Sao_Paulo

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario_do_banco
DB_PASSWORD=senha_forte

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=local
MEDIA_DISK=public

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=usuario_smtp
MAIL_PASSWORD=senha_smtp
MAIL_ENCRYPTION=tls
APP_PUBLIC_NAME="${APP_NAME}"
APP_CONTACT_NAME="${APP_PUBLIC_NAME}"
APP_CONTACT_EMAIL="contato@seudominio.com"
APP_CONTACT_PHONE=
APP_CONTACT_URL=https://seudominio.com/contato
MAIL_FROM_ADDRESS="${APP_CONTACT_EMAIL}"
MAIL_FROM_NAME="${APP_CONTACT_NAME}"

APP_SEO_DEFAULT_TITLE="${APP_PUBLIC_NAME}"
APP_SEO_TITLE_SUFFIX=" | ${APP_PUBLIC_NAME}"
APP_SEO_DEFAULT_DESCRIPTION="Descrição pública do produto."
APP_SEO_DEFAULT_IMAGE=https://seudominio.com/images/social-default.png
APP_SEO_TWITTER_CARD=summary_large_image
APP_SEO_ROBOTS=index,follow
APP_FLAG_PUBLIC_REGISTRATION=true
APP_FLAG_MEDIA_UPLOADS=true

GROWTH_ENABLED=false
GROWTH_RETENTION_DAYS=365
GA_ENABLED=false
GA_MEASUREMENT_ID=

VITE_APP_NAME="${APP_PUBLIC_NAME}"
VITE_GROWTH_ENABLED="${GROWTH_ENABLED}"
```

Obrigatório:

- Mantenha `APP_DEBUG=false` em produção.
- Gere `APP_KEY` com `php artisan key:generate` se ainda não existir.
- Use credenciais reais de banco, e-mail e domínio.
- Não publique `.env` nem deixe o document root apontado para a raiz do projeto.
- Revise `MEDIA_DISK`: arquivos sensíveis devem usar disco privado e entrega autorizada ou URL temporária.

## 4. Banco, cache e storage

Execute os comandos de preparação:

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Use `php artisan optimize:clear` antes de recriar caches quando alterar `.env`, rotas, config ou views.

## 5. Public root, Nginx e CloudPanel

O document root do site deve apontar para a pasta `public` do projeto.

Exemplo mínimo de Nginx:

```nginx
server {
    listen 80;
    server_name seudominio.com www.seudominio.com;
    root /home/site/htdocs/seudominio.com/public;

    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

O valor de `fastcgi_pass` é apenas exemplo. Ajuste o socket ou host/porta conforme a versão PHP e a configuração do PHP-FPM no servidor.

No CloudPanel ou painel similar:

1. Configure o site como PHP.
2. Aponte o document root para `public`.
3. Configure PHP 8.3 ou superior.
4. Configure HTTPS.
5. Confirme que `.env`, `storage`, `vendor` e arquivos de código não são acessíveis pelo navegador.

## 6. Scheduler e filas

O starter usa `QUEUE_CONNECTION=database` e possui scheduler inicial. Para produção recorrente, configure pelo menos o cron do Laravel:

```bash
* * * * * cd /caminho/do/projeto && php artisan schedule:run >> /dev/null 2>&1
```

Se o produto derivado usar jobs assíncronos reais, configure um worker persistente com Supervisor, systemd ou recurso equivalente do provedor. Não trate `queue:listen` como solução final de produção.

## 7. Validação pós-deploy

1. Acesse `https://seudominio.com/up` e confirme HTTP 200.
2. Acesse a home e confirme que não há erro 500.
3. Confirme que assets Vite carregam sem 404.
4. Crie uma conta de teste e acesse o dashboard.
5. Solicite reset de senha e confirme recebimento por SMTP real.
6. Faça upload de um arquivo permitido e confirme acesso conforme a política de storage definida.
7. Com `GA_ENABLED=false`, confirme no Network que não há requests para `googletagmanager.com` nem `analytics.google.com/g/collect`.
8. Revise logs em `storage/logs` após a validação.

## 8. Rollback manual

Antes de cada deploy, mantenha uma versão anterior conhecida e um backup recente. Em caso de falha:

1. Reaponte o release atual para a versão anterior ou restaure os arquivos da versão estável.
2. Restaure o backup do banco se o deploy executou migrations incompatíveis.
3. Execute `php artisan optimize:clear`.
4. Recrie caches com `php artisan config:cache`, `php artisan route:cache` e `php artisan view:cache`.
5. Valide `/up`, home, login e logs antes de liberar o tráfego novamente.

## 9. Antes de liberar

- Faça backup do banco e dos arquivos persistentes.
- Confirme que existe caminho simples de rollback para a versão anterior.
- Confirme que o domínio usa HTTPS.
- Confirme que `APP_DEBUG=false` continua ativo.
- Confirme que `/up` está monitorável pelo provedor ou ferramenta externa.
