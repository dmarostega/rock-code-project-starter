# Auditoria mínima

Este starter registra somente ações críticas de segurança e operação. Auditoria
não é analytics, log técnico nem uma trilha completa de toda navegação.

## Ações incluídas

- `admin.accessed`: acesso bem-sucedido à área administrativa.
- `admin.configuration.updated`: alteração de configuração administrativa.
- `media.deleted`: remoção de mídia.
- `user.deleted`: remoção de conta.
- `user.role.changed`: alteração de papel ou permissão.

As quatro últimas ações são previstas para módulos que venham a ser ativados no
produto derivado. Não as registre antes de a operação correspondente existir e
estar autorizada. Para uma nova ação, atualize `config/audit.php`, esta lista e
os testes associados.

## Dados registrados

Cada registro contém apenas: ator (`actor_id`, quando disponível), ação, tipo e
identificador técnico do alvo, e data/hora. A estrutura não aceita metadata;
assim, não persiste nomes, e-mails, conteúdo enviado, valores de negócio,
senhas, tokens, cookies, chaves, cabeçalhos ou outros dados sensíveis.

Use `App\Services\AuditLogger` para gravar uma ação permitida. Não grave
diretamente no model e não reutilize a tabela para depuração ou métricas.

## Acesso, retenção e operação

Não há interface pública ou administrativa para os registros. O produto
derivado deve restringir consultas a pessoas autorizadas, definir retenção e
descarte compatíveis com sua finalidade e configurar `AUDIT_RETENTION_DAYS`
(365 dias por padrão) antes de operar em produção. Backups e exportações devem
seguir uma política própria de acesso e retenção.
