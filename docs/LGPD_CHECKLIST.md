# Checklist LGPD base

Use este checklist antes de colocar em produção um produto derivado deste starter. Ele registra decisões mínimas de privacidade e não substitui a análise jurídica, de segurança ou de conformidade aplicável ao produto.

## 1. Dados coletados

- [ ] Listar cada dado pessoal coletado pelo produto, inclusive os recebidos por formulários, autenticação, uploads, suporte, integrações e eventos de Growth.
- [ ] Para cada dado, registrar a origem, se o fornecimento é obrigatório, quem pode acessá-lo e em quais sistemas ele fica armazenado.
- [ ] Confirmar que o produto coleta somente os dados necessários para a finalidade definida.

## 2. Finalidade e base legal

- [ ] Documentar a finalidade específica de cada categoria de dado pessoal.
- [ ] Definir e registrar a base legal aplicável para cada finalidade, com validação jurídica quando necessária.
- [ ] Revisar textos de privacidade, formulários e fluxos de consentimento para que correspondam ao tratamento implementado.

## 3. Retencao e descarte

- [ ] Definir o prazo de retenção de cada categoria de dado e o critério que inicia sua contagem.
- [ ] Definir como os dados serão excluídos, anonimizados ou bloqueados ao fim do prazo, incluindo backups quando aplicável.
- [ ] Configurar `GROWTH_RETENTION_DAYS` de acordo com a decisão de retenção dos eventos first-party.
- [ ] Registrar responsável e frequência da revisão dos prazos de retenção.

## 4. Growth, metadata e GA4

- [ ] Manter `GROWTH_ENABLED=false` até que finalidade, taxonomia, base legal, consentimento quando aplicável e retenção estejam aprovados.
- [ ] Adotar a [taxonomia mínima de eventos](ANALYTICS_EVENT_TAXONOMY.md), definir os valores enumerados do produto e implementar sua allowlist positiva de metadata antes de habilitar novos campos.
- [ ] Nunca incluir em metadata dados pessoais, credenciais, tokens, dados de autenticação, documentos, valores financeiros sensíveis, dados de saúde, identificadores governamentais ou conteúdo livre que possa conter essas informações.
- [ ] Manter `GA_ENABLED=false` e `GA_MEASUREMENT_ID=` até que a mesma avaliação de finalidade, consentimento quando aplicável e configuração de produção esteja concluída.
- [ ] Confirmar que Growth e GA4 permanecem opt-in: não habilitar nenhum dos dois por padrão nem como efeito colateral de outro recurso.

## 5. Arquivos sensiveis

- [ ] Classificar quais tipos de arquivo podem conter dados pessoais ou conteúdo restrito antes de habilitar uploads.
- [ ] Usar disco privado para arquivos sensíveis; não publicar documentos, contratos, faturas, arquivos médicos/legais ou equivalentes em `MEDIA_DISK=public`.
- [ ] Implementar entrega autorizada ou URL temporária para arquivos privados antes de disponibilizá-los a usuários.
- [ ] Revisar nomes originais, metadados e previews para evitar exposição de dados pessoais em APIs, logs ou URLs públicas.

## 6. Evidencias e aprovacao

- [ ] Guardar o inventário de dados, finalidades, bases legais, prazos e decisões de consentimento no repositório ou no sistema de governança do produto.
- [ ] Registrar as exceções aprovadas, o responsável pela decisão e a data da próxima revisão.
- [ ] Validar este checklist novamente quando houver novo dado coletado, integração, fluxo de upload, evento de Growth ou mudança em analytics.

## Referencias no starter

- A configuração e os limites atuais de Growth estão em `docs/ARCHITECTURE.md`, `docs/ANALYTICS_EVENT_TAXONOMY.md` e `docs/MANUAL_TESTS.md`.
- A decisão entre storage público e privado está em `docs/ARCHITECTURE.md` e `docs/DEPLOY.md`.
- O checklist geral de início do produto está em `docs/ADOPTION_CHECKLIST.md`.
