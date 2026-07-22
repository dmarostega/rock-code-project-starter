# Checklist para iniciar um projeto

## Flags de recurso

- [ ] Para cada rota opcional, aplicar o middleware `feature:nome_da_flag`; a flag deve impedir o acesso no servidor, nao apenas ocultar a interface. `media_uploads` e o exemplo-base e retorna 404 quando desligada.

- [ ] Ler `docs/V01_SCOPE.md` e confirmar que o produto aceita a v0.1 como base experimental para MVP, sem assumir billing, planos, admin real, exportações ou operação madura no core.
- [ ] Alterar `APP_NAME` e `APP_PUBLIC_NAME`; use `APP_NAME` para identificação interna Laravel e `APP_PUBLIC_NAME` para nome visível do produto.
- [ ] Configurar contato principal público em `APP_CONTACT_NAME`, `APP_CONTACT_EMAIL`, `APP_CONTACT_PHONE` e `APP_CONTACT_URL`; não use esse grupo para dados internos, pessoais ou operacionais sensíveis.
- [ ] Revisar `APP_SEO_DEFAULT_TITLE`, `APP_SEO_TITLE_SUFFIX`, `APP_SEO_DEFAULT_DESCRIPTION`, `APP_SEO_DEFAULT_IMAGE`, `APP_SEO_TWITTER_CARD`, `APP_SEO_ROBOTS`, `APP_SEO_SITEMAP_PATHS` e `APP_SEO_ROBOTS_DISALLOW`; produtos públicos devem definir `APP_SEO_DEFAULT_IMAGE`.
- [ ] Revisar flags simples `APP_FLAG_PUBLIC_REGISTRATION`, `APP_FLAG_MEDIA_UPLOADS` e `GROWTH_ENABLED`; elas são fundação de config, não substituem Policies, middleware ou regras de negócio.
- [ ] Alterar descrição, URLs e identidade visual.
- [ ] Escolher MySQL/PostgreSQL/SQLite e configurar `.env`.
- [ ] Remover módulos opcionais que o produto não utilizará.
- [ ] Definir domínio, casos de uso, Policies e eventos principais.
- [ ] Preencher `docs/LGPD_CHECKLIST.md`, registrar as decisões de privacidade do produto e revisar o checklist a cada alteração relevante de dados, uploads, Growth ou analytics.
- [ ] Decidir se o produto vai exigir verificação de e-mail; se sim, habilitar Fortify email verification, `MustVerifyEmail` e middleware `verified`.
- [ ] Habilitar `GROWTH_ENABLED` somente depois de definir finalidade, taxonomia, consentimento, retenção e campos proibidos de metadata.
- [ ] Definir a política de storage público vs privado; `MEDIA_DISK=public` é aceitável apenas para assets públicos, enquanto documentos sensíveis devem usar disco privado e entrega autorizada/temporária.
- [ ] Registrar a necessidade de download protegido para arquivos privados como pendência futura (P1/P2), se o produto exigir acesso controlado sem expor URLs públicas.
- [ ] Revisar se `original_name` pode expor dado pessoal antes de retornar assets de mídia em APIs públicas.
- [ ] Atualizar sitemap, robots, SEO padrão e imagem social usando a fundação de `config/app_settings.php`; inclua apenas páginas públicas indexáveis no sitemap e deixe `APP_SEO_ROBOTS_DISALLOW` vazio, salvo quando a intenção for impedir crawling de rotas específicas.
- [ ] Configurar mail, queue, backup, logs e observabilidade.
- [ ] Configurar banco isolado de testes e secrets do CI/deploy.
- [ ] Registrar quais funcionalidades fora do core da v0.1 serão implementadas no produto derivado.
