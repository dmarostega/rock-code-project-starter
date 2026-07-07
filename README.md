# Rock Code Project Starter

Base opinativa para novos produtos web da Rock Code. Combina a organizacao amadurecida nos projetos SaaS com a stack moderna de Vue/Inertia adotada no projeto `loteries`, sem carregar dominio de propostas, ordens, loterias ou assinaturas.

## Stack

- PHP 8.3 e Laravel 13
- Vue 3 exclusivamente com TypeScript
- Inertia 2 e Tailwind CSS 4
- Fortify para autenticacao e Sanctum para API
- Pest, Pint, ESLint, Prettier e `vue-tsc`

## Recursos incluidos

- Autenticacao minima com login, cadastro e recuperacao via Fortify.
- SEO por pagina, canonical, Open Graph, Twitter Card, sitemap e robots.
- Tracking first-party de eventos e atribuicao UTM, desligado por padrao ate o produto definir finalidade, taxonomia e consentimento.
- GA4/GTag opcional via `GA_ENABLED=false` e `GA_MEASUREMENT_ID=`, com guards de producao, debug e host local.
- Upload de imagens/PDF, WebP, limite de dimensao, Storage e Policy.
- SQLite local por padrao, filas e cache em banco, endpoint `/up` e CI.
- Documentacao de arquitetura, adocao e testes manuais.

## Instalacao

Quando o projeto for adotado:

```bash
composer setup
php artisan storage:link
composer dev
```

No PowerShell, use `npm.cmd` quando a politica de execucao bloquear `npm.ps1`.

## Qualidade

```bash
composer lint
npm run quality
composer test
composer ci:check
```

Leia primeiro `docs/ADOPTION_CHECKLIST.md` e remova tudo que o novo produto nao precisar.
