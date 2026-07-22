# Blueprint de planos e feature access

Este documento orienta a evolução de um produto derivado que precisa oferecer
planos, período de teste, limites de uso e liberações comerciais. Ele não
implementa cobrança nem altera o core do starter.

## Decisão de escopo

O starter permanece sem billing, checkout, assinatura recorrente, invoice ou
integração com gateway. Essas decisões dependem do produto, da jurisdição, do
modelo comercial e do provedor escolhido. O core oferece apenas a referência
para que a futura autorização seja aplicada no servidor.

## Modelo de acesso recomendado

Cada produto deve definir identificadores estáveis e independentes da interface:

| Estado | Finalidade | Regra de acesso |
| --- | --- | --- |
| `free` | Entrada padrão sem pagamento. | Libera recursos básicos e aplica os limites do plano. |
| `trial` | Avaliação temporária de uma oferta. | Libera o conjunto definido para o trial até `trial_ends_at`; depois aplica a política explícita de expiração. |
| `premium` | Oferta paga ou contratada. | Libera os recursos e limites contratados enquanto o entitlement estiver ativo. |

Os nomes comerciais podem mudar; os identificadores técnicos devem continuar
estáveis. Um usuário não deve receber acesso porque a UI exibe um botão ou uma
etiqueta de plano: o servidor deve decidir a autorização em toda rota, action,
job, exportação e endpoint de API protegido.

## Feature access server-side

Modele o acesso como uma decisão central, por exemplo `FeatureAccessService`,
recebendo o ator, o recurso e o contexto necessário. A decisão deve considerar,
nesta ordem:

1. bloqueios ou expiração explícitos;
2. grants manuais ativos;
3. entitlement ativo do plano ou trial;
4. limite de uso do recurso;
5. regra padrão de negação.

Use Policies, middleware, Form Requests ou Services conforme o ponto de entrada,
mas mantenha uma única fonte de verdade para a regra. `APP_FLAG_*` continua útil
para habilitar ou desligar módulos por ambiente; não deve ser usado como
substituto de entitlement por usuário, organização ou assinatura.

Retorne `403` quando o recurso existe e o ator autenticado não tem acesso. Use
`404` somente quando a política do produto exigir ocultar a existência do
recurso, de forma consistente. Não confie em plano, grant, contador ou feature
enviado pelo cliente.

## Limites por recurso

Defina limites por identificador técnico de recurso, não por tela. Exemplos:

| Recurso | Medida | Janela sugerida |
| --- | --- | --- |
| `projects` | projetos ativos | estado atual |
| `exports` | exportações concluídas | mês-calendário |
| `api_requests` | requisições aceitas | minuto ou dia |
| `storage_bytes` | bytes armazenados | estado atual |

O contador deve ser atualizado no servidor na mesma transação, ou por mecanismo
idempotente equivalente, que cria o recurso consumido. Para operações
assíncronas, reserve a cota antes do job e confirme, libere ou reconcilie a
reserva quando ele terminar. Registre timezone, regra de reinício e o tratamento
de retries para evitar consumo duplicado ou ultrapassagem por concorrência.

## Grants manuais

Grants são exceções comerciais ou operacionais e não substituem um plano. Um
grant deve conter, no mínimo, o alvo (usuário ou organização), a feature ou
limite concedido, início, expiração opcional, motivo, origem e quem autorizou.

- Grants devem ser avaliados no servidor e expirar automaticamente.
- Revogação deve ter efeito imediato na próxima decisão de acesso.
- A criação, alteração e revogação precisam de autorização administrativa e
  trilha de auditoria sem dados sensíveis desnecessários.
- Um grant ilimitado ou sem expiração exige justificativa explícita e revisão
  periódica.

## Dados mínimos para a implementação futura

O produto pode separar as seguintes responsabilidades em tabelas ou provedores:

- catálogo de planos e versões de limite;
- entitlements ativos por usuário ou organização;
- grants manuais e auditoria;
- contadores ou reservas de uso por recurso e janela;
- adaptador de billing que sincroniza eventos externos com entitlements.

O adaptador de billing não deve conceder acesso diretamente a partir de um
webhook sem validação, idempotência e reconciliação. Ele atualiza o entitlement;
o serviço central de access controla a autorização.

## Quando implementar

Implemente este desenho no produto derivado quando houver ao menos um destes
gatilhos:

- uma feature precisa ser liberada para apenas parte da base;
- uma operação exige limite mensurável ou proteção contra abuso;
- existe trial, contrato, venda manual ou suporte comercial que exige exceção;
- o produto vai integrar um gateway ou processar eventos de cobrança.

Antes de codificar, defina a matriz plano × feature × limite, o dono comercial,
a política de expiração/cancelamento, a UX de bloqueio e upgrade, a estratégia
de auditoria e os testes de autorização, concorrência, expiração e idempotência.
Billing só entra após essas decisões e com segurança, privacidade, impostos,
suporte e reconciliação próprios do produto.
