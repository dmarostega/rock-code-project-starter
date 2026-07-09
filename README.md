# Rock Code Project Starter

Base opinativa para novos produtos web da Rock Code. Combina a organizacao amadurecida nos projetos SaaS com a stack moderna de Vue/Inertia adotada no projeto `loteries`, sem carregar dominio de propostas, ordens, loterias ou assinaturas.

## Status da v0.1

A v0.1 e uma base oficial experimental para MVPs Laravel + Vue/Inertia. Ela padroniza o ponto de partida tecnico, mas nao e um micro-SaaS premium completo.

Antes de usar em um produto, leia `docs/V01_SCOPE.md` e execute `docs/ADOPTION_CHECKLIST.md`. Billing, planos, admin real, exportacoes, operacao madura e recursos premium devem ser planejados no produto derivado, fora do core da v0.1.

## Stack

- PHP 8.4 e Laravel 13
- Vue 3 exclusivamente com TypeScript
- Inertia 2 e Tailwind CSS 4
- Fortify para autenticacao e Sanctum para API
- Pest, Pint, ESLint, Prettier e `vue-tsc`

## Recursos incluidos

- Autenticacao minima com login, cadastro e recuperacao via Fortify.
- SEO por página, canonical, Open Graph, Twitter Card, sitemap e robots.
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

## Documentacao

- Leia `docs/V01_SCOPE.md` para entender o escopo oficial, as limitacoes e o que fica fora do core da v0.1 experimental.
- Leia `docs/ADOPTION_CHECKLIST.md` antes de iniciar um produto e remova tudo que o novo produto nao precisar.
- Use `docs/DEPLOY.md` como roteiro minimo para deploy manual em VPS, CloudPanel ou ambiente equivalente.
