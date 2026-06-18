# Rock Code Project Starter

Base opinativa para novos produtos web da Rock Code. Combina a organização amadurecida nos projetos SaaS com a stack moderna de Vue/Inertia adotada no projeto `loteries`, sem carregar domínio de propostas, ordens, loterias ou assinaturas.

## Stack

- PHP 8.3 e Laravel 13
- Vue 3 exclusivamente com TypeScript
- Inertia 2 e Tailwind CSS 4
- Fortify para autenticação e Sanctum para API
- Pest, Pint, ESLint, Prettier e `vue-tsc`

## Recursos incluídos

- Autenticação mínima com login, cadastro e recuperação via Fortify.
- SEO por página, canonical, Open Graph, Twitter Card, sitemap e robots.
- Tracking first-party de eventos e atribuição UTM com retenção configurável.
- Upload de imagens/PDF, WebP, limite de dimensão, Storage e Policy.
- SQLite local por padrão, filas e cache em banco, endpoint `/up` e CI.
- Documentação de arquitetura, adoção e testes manuais.

## Instalação futura

As dependências não foram instaladas nesta entrega. Quando o projeto for adotado:

```bash
composer setup
php artisan storage:link
composer dev
```

No PowerShell, use `npm.cmd` quando a política de execução bloquear `npm.ps1`.

## Qualidade

```bash
composer lint
npm run quality
composer test
composer ci:check
```

Leia primeiro `docs/ADOPTION_CHECKLIST.md` e remova tudo que o novo produto não precisar.
