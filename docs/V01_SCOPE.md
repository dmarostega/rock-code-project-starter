# Escopo oficial da v0.1 experimental

## Decisao

A v0.1 do Rock Code Project Starter e uma base oficial experimental para iniciar MVPs Laravel + Vue/Inertia na Rock Code.

Ela foi aprovada com ressalvas para acelerar novos produtos, padronizar escolhas tecnicas iniciais e reduzir repeticao entre projetos. A v0.1 nao deve ser tratada como um micro-SaaS premium completo nem como uma base madura de operacao.

## O que entra no core da v0.1

- Estrutura Laravel + Inertia + Vue 3 com TypeScript.
- Autenticacao minima com Fortify.
- Paginas iniciais publicas, login, cadastro, reset de senha e dashboard simples.
- SEO basico, sitemap e robots.
- Tracking first-party opcional e GA4 opcional com guards para ambiente local/debug.
- Upload basico de imagens e PDF com Policy, validacao e Storage.
- Testes automatizados iniciais e roteiro manual de validacao.
- Documentacao de arquitetura, adocao e deploy minimo.

## Limitacoes assumidas

- A v0.1 e experimental e deve ser revisada antes de uso em producao.
- Os modulos incluidos sao exemplos reutilizaveis e podem ser removidos quando o produto nao precisar deles.
- A base nao substitui analise de seguranca, privacidade, LGPD, observabilidade, backup, suporte ou operacao do produto final.
- O produto derivado deve definir dominio, regras de negocio, politicas de acesso, retencao de dados e consentimento.
- Storage publico, analytics e tracking devem ser revalidados para cada produto antes de publicar.

## Fora do core da v0.1

- Billing, planos, assinaturas, checkout ou integracao com gateway de pagamento.
- Admin real, backoffice operacional, profile/settings completos ou gestao de usuarios avancada.
- Exportacoes, relatorios gerenciais ou dashboards de negocio.
- Multi-tenant, RBAC avancado, auditoria completa ou workflows maduros.
- Operacao completa de producao, monitoramento, backup automatizado e incident response.
- Componentes premium especificos de um produto ou vertical de negocio.

## Checklist minimo antes de usar

Antes de adotar a v0.1 em um produto, execute o checklist de adocao em `docs/ADOPTION_CHECKLIST.md` e o roteiro manual em `docs/MANUAL_TESTS.md`.

Se o produto precisar de itens fora do core, trate-os como escopo do produto derivado, nao como responsabilidade implicita do starter.
