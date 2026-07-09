# Checklist para iniciar um projeto

- [ ] Ler `docs/V01_SCOPE.md` e confirmar que o produto aceita a v0.1 como base experimental para MVP, sem assumir billing, planos, admin real, exportacoes ou operacao madura no core.
- [ ] Alterar `APP_NAME` e `APP_PUBLIC_NAME`; use `APP_NAME` para identificacao interna Laravel e `APP_PUBLIC_NAME` para nome visivel do produto.
- [ ] Configurar contato principal em `APP_CONTACT_NAME`, `APP_CONTACT_EMAIL`, `APP_CONTACT_PHONE` e `APP_CONTACT_URL`.
- [ ] Revisar `APP_SEO_DEFAULT_TITLE`, `APP_SEO_TITLE_SUFFIX`, `APP_SEO_DEFAULT_DESCRIPTION`, `APP_SEO_DEFAULT_IMAGE`, `APP_SEO_TWITTER_CARD` e `APP_SEO_ROBOTS`.
- [ ] Revisar flags simples `APP_FLAG_PUBLIC_REGISTRATION`, `APP_FLAG_MEDIA_UPLOADS` e `GROWTH_ENABLED`; elas sao fundacao de config, nao substituem Policies, middleware ou regras de negocio.
- [ ] Alterar descricao, URLs e identidade visual.
- [ ] Escolher MySQL/PostgreSQL/SQLite e configurar `.env`.
- [ ] Remover modulos opcionais que o produto nao utilizara.
- [ ] Definir dominio, casos de uso, Policies e eventos principais.
- [ ] Decidir se o produto vai exigir verificacao de e-mail; se sim, habilitar Fortify email verification, `MustVerifyEmail` e middleware `verified`.
- [ ] Habilitar `GROWTH_ENABLED` somente depois de definir finalidade, taxonomia, consentimento, retencao e campos proibidos de metadata.
- [ ] Definir a política de storage publico vs privado; `MEDIA_DISK=public` é aceitável apenas para assets publicos, enquanto documentos sensiveis devem usar disco privado e entrega autorizada/temporaria.
- [ ] Registrar a necessidade de download protegido para arquivos privados como pendência futura (P1/P2), se o produto exigir acesso controlado sem expor URLs públicas.
- [ ] Revisar se `original_name` pode expor dado pessoal antes de retornar assets de midia em APIs publicas.
- [ ] Atualizar sitemap, robots, SEO padrao e imagem social usando a fundacao de `config/app_settings.php`.
- [ ] Configurar mail, queue, backup, logs e observabilidade.
- [ ] Configurar banco isolado de testes e secrets do CI/deploy.
- [ ] Registrar quais funcionalidades fora do core da v0.1 serao implementadas no produto derivado.
