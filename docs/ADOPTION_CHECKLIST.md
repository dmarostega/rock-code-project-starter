# Checklist para iniciar um projeto

- [ ] Ler `docs/V01_SCOPE.md` e confirmar que o produto aceita a v0.1 como base experimental para MVP, sem assumir billing, planos, admin real, exportacoes ou operacao madura no core.
- [ ] Alterar nome, descricao, URLs e identidade visual.
- [ ] Escolher MySQL/PostgreSQL/SQLite e configurar `.env`.
- [ ] Remover modulos opcionais que o produto nao utilizara.
- [ ] Definir dominio, casos de uso, Policies e eventos principais.
- [ ] Decidir se o produto vai exigir verificacao de e-mail; se sim, habilitar Fortify email verification, `MustVerifyEmail` e middleware `verified`.
- [ ] Habilitar `GROWTH_ENABLED` somente depois de definir finalidade, taxonomia, consentimento, retencao e campos proibidos de metadata.
- [ ] Configurar storage publico/privado e limites de upload; documentos sensiveis devem usar disco privado e entrega autorizada/temporaria.
- [ ] Revisar se `original_name` pode expor dado pessoal antes de retornar assets de midia em APIs publicas.
- [ ] Atualizar sitemap, robots, SEO padrao e imagem social.
- [ ] Configurar mail, queue, backup, logs e observabilidade.
- [ ] Configurar banco isolado de testes e secrets do CI/deploy.
- [ ] Registrar quais funcionalidades fora do core da v0.1 serao implementadas no produto derivado.
