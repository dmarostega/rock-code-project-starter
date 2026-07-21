# Taxonomia mínima de eventos

Esta é a taxonomia inicial para o módulo opcional de Growth e analytics
first-party. Ela define o limite de dados que um produto derivado pode coletar;
não é uma autorização para ativar coleta. Mantenha `GROWTH_ENABLED=false` até
que finalidade, base legal, consentimento quando aplicável, retenção e
implementação da allowlist sejam aprovados.

Não implemente dashboard analítico neste starter. Produtos derivados devem
adotar somente os eventos necessários para sua finalidade documentada.

## Eventos permitidos

Use nomes em minúsculas, separados por ponto, conforme a validação do endpoint.
Não crie eventos livres no cliente nem use o nome do evento para transportar
identificadores, conteúdo ou atributos de pessoas.

| Evento | Finalidade permitida | Metadata permitida |
| --- | --- | --- |
| `page.viewed` | Medir a visualização de uma página pública. | `page_type`, `surface`, `locale` |
| `cta.clicked` | Medir a interação com uma chamada para ação. | `cta_id`, `placement`, `surface`, `variant` |
| `form.started` | Medir o início de um formulário sem registrar os campos preenchidos. | `form_id`, `surface` |
| `form.submitted` | Medir o envio bem-sucedido de um formulário sem registrar valores enviados. | `form_id`, `surface` |
| `sign_up.completed` | Medir a conclusão do cadastro. | `method`, `surface` |
| `sign_in.completed` | Medir a conclusão da autenticação. | `method`, `surface` |
| `feature.used` | Medir o uso de uma funcionalidade aprovada. | `feature_id`, `surface`, `variant` |

`page_type`, `surface`, `cta_id`, `placement`, `form_id` e `feature_id` são
identificadores estáveis definidos pelo produto, e não URLs, textos exibidos ou
valores fornecidos por usuários. `method`, `variant` e `locale` devem usar
valores enumerados e revisados. Antes de adicionar um evento ou campo, registre
a finalidade, responsável, base legal, retenção e a alteração na implementação.

## Allowlist de metadata

Aceite somente as chaves listadas abaixo, no contexto do evento correspondente.
Os valores devem ser escalares, com no máximo 255 caracteres; objetos, arrays,
conteúdo livre e campos não listados são recusados. O limite total permanece em
20 campos por evento, embora esta taxonomia use no máximo quatro.

- `page_type`: categoria interna e enumerada da página pública, como `home` ou
  `pricing`.
- `surface`: área enumerada da interface, como `web_public` ou `dashboard`.
- `locale`: código de idioma enumerado, como `pt-BR`.
- `cta_id`: identificador técnico e estável da CTA, como `hero_start`.
- `placement`: posição enumerada do elemento, como `hero` ou `header`.
- `variant`: variante de experimento ou interface previamente aprovada, como
  `control` ou `b`.
- `form_id`: identificador técnico e estável do formulário, como
  `contact_request`.
- `method`: método enumerado, como `password` ou `google` quando a integração
  existir.
- `feature_id`: identificador técnico e estável da funcionalidade, como
  `media_upload`.

A configuração atual aplica esta allowlist positiva por evento e bloqueia chaves
perigosas e tipos aninhados. Ao adicionar um evento ou campo em um produto
derivado, atualize a configuração, documente a decisão e cubra a alteração com
testes; uma blocklist isolada não torna uma nova chave permitida.

## Dados proibidos

Nunca envie para eventos, metadata, nome do evento, `path`, `referrer` ou UTM:

- dados pessoais diretos ou indiretos, como nome, e-mail, telefone, endereço,
  IP, identificadores de dispositivo, identificador de usuário, CPF, CNPJ ou
  documento;
- credenciais, senhas, tokens, cookies, cabeçalhos de autorização, IDs de
  sessão, chaves ou segredos;
- conteúdo de campos, consultas, URLs com parâmetros, texto livre, uploads ou
  documentos;
- dados financeiros, de pagamento, saúde, biometria, religião, opinião política
  ou qualquer dado pessoal sensível;
- valores de negócio que revelem dados de uma pessoa, como preço negociado,
  limite, saldo, pedido, contrato ou diagnóstico.

O starter já armazena `ip_hash`, nunca IP em claro. Trate `anonymous_id`,
`user_id`, `user_agent`, `path`, `referrer` e parâmetros de atribuição como
dados que exigem finalidade, minimização e controle de acesso, mesmo que não
pertençam à metadata.

## Retenção e descarte

O padrão técnico é `GROWTH_RETENTION_DAYS=365`. O scheduler remove diariamente
os registros de `growth_events` anteriores a esse prazo. Cada produto deve
aprovar prazo menor ou igual ao necessário, registrar o responsável e revisar a
decisão pelo menos anualmente ou quando a finalidade mudar.

Backups, exportações e ferramentas externas que recebam os dados devem ter
prazo de retenção e descarte documentados separadamente. A remoção do banco
operacional não substitui essa revisão.

## Separação de finalidades

| Categoria | Uso | Não usar para |
| --- | --- | --- |
| Analytics first-party | Métricas agregadas de navegação e uso, restritas a esta taxonomia. | Depuração detalhada, evidência de ação ou perfil individual. |
| Logs técnicos | Diagnóstico de erros, desempenho e operação, com acesso operacional restrito. | Métricas de produto ou conteúdo de formulário. |
| Auditoria | Rastreabilidade de ações relevantes de segurança e negócio, com integridade e acesso controlado. | Funil, experimentos ou métricas de engajamento. |

Não replique dados entre essas categorias sem uma finalidade compatível,
avaliação de necessidade e atualização da documentação de privacidade.

## Aprovação antes da ativação

1. Documente o evento, a finalidade, os valores enumerados e o responsável.
2. Confirme base legal e consentimento quando aplicável com o responsável de
   privacidade/jurídico.
3. Revise e teste a allowlist positiva, incluindo a rejeição de campos
   desconhecidos.
4. Configure a retenção aprovada, valide o scheduler e registre a revisão.
5. Só então habilite `GROWTH_ENABLED=true`; GA4 continua uma decisão separada
   e também começa desligado.
