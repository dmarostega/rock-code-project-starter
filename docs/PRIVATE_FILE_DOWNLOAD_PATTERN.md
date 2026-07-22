# Padrão de download protegido para arquivos privados

Este documento define a evolução para produtos que precisem armazenar documentos restritos. Ele é um padrão de adoção: não habilita armazenamento sensível, não cria rotas e não altera o comportamento público atual.

## Escopo e decisão de storage

O módulo de mídia atual usa `MEDIA_DISK=public` e gera URLs públicas para imagens e documentos destinados à divulgação. Esse comportamento continua adequado somente para conteúdo que possa ser acessado por qualquer pessoa com a URL.

Quando um produto incluir contratos, faturas, documentos com dados pessoais, relatórios internos ou conteúdo médico/legal, ele deve:

- armazenar o arquivo em um disco sem URL pública, como o disco Laravel `local` (`storage/app/private`) ou um bucket privado;
- persistir no registro do arquivo o disco privado e o caminho interno, nunca uma URL pública;
- entregar o conteúdo apenas depois de autenticação e autorização do recurso.

Não execute `storage:link` para expor esse disco e não reutilize o accessor `MediaAsset::url` para representar um arquivo privado. A API ou a página do produto deve receber uma rota de download autorizada, não o caminho nem a URL do provider.

## Autorização

Antes de criar a rota, amplie a Policy do recurso de domínio. Para o módulo genérico atual, a evolução esperada é `MediaAssetPolicy::view(User $user, MediaAsset $asset): bool`; a mesma regra pode também atender `download` se o produto não precisar separar visualização e exportação.

A regra não deve pressupor que o proprietário seja sempre o único autorizado. O produto derivado deve codificar a relação de negócio adequada, por exemplo:

- dono do arquivo;
- participante de uma organização ou do registro ao qual o arquivo pertence;
- usuário com permissão administrativa explícita;
- acesso revogado quando o vínculo, contrato ou conta deixar de ser válido.

O controller deve chamar `$this->authorize('view', $mediaAsset)` antes de consultar o disco. Não aceite `disk`, `path`, nome de arquivo ou URL fornecidos pela requisição; use apenas o registro já recuperado por route model binding e trate `404` sem revelar a existência do arquivo para quem não tem acesso.

## Estratégias de entrega

### Endpoint autorizado (padrão inicial)

Use uma rota autenticada, por exemplo `GET /media/{mediaAsset}/download`, quando a aplicação precisar centralizar autorização, registrar auditoria ou suportar o disco local privado. Após a Policy, entregue o arquivo com `Storage::disk($asset->disk)->download($asset->path, $downloadName)` ou `response()->file()` para visualização inline quando isso estiver autorizado.

O nome sugerido ao navegador deve ser tratado como apresentação. Normalize caracteres de controle e avalie não expor `original_name` quando ele puder conter dados pessoais. O MIME type deve vir do registro validado no upload, não de um header enviado pelo cliente.

### URL temporária do provider

Em storage que suporte URLs temporárias, como S3, o endpoint autorizado pode gerar `Storage::disk($asset->disk)->temporaryUrl(...)` somente depois da Policy e redirecionar o usuário. Essa opção reduz tráfego pela aplicação, mas a URL continua sendo um bearer token até expirar.

Use-a apenas quando o provider, o prazo curto e a revogação operacional forem aceitáveis. Não a use com disco local; não persista a URL no banco, cache compartilhado, resposta reutilizável ou logs.

## Controles obrigatórios na implementação

- A rota deve ficar atrás de `auth`; inclua `verified` quando o produto exigir e-mail verificado.
- A Policy deve ser testada para usuário autorizado, não autorizado e acesso administrativo permitido, quando aplicável.
- O arquivo deve permanecer fora de `public/` e fora de qualquer symlink servido pelo servidor web.
- A resposta deve usar headers adequados (`Content-Disposition`, tipo de conteúdo validado e `Cache-Control: private, no-store` para documentos sensíveis).
- Registre uma auditoria técnica de download sem nome do arquivo, URL temporária, conteúdo, token ou dados pessoais; inclua somente ator, recurso técnico, resultado e data/hora, conforme a política do produto.
- Defina limites de tamanho, MIME e antivírus/scan quando o risco e o provider exigirem; autorização de download não substitui validação segura no upload.
- Revise backups, logs, previews e integrações para que o conteúdo ou metadados sensíveis não sejam expostos indiretamente.

## Plano de implementação no produto derivado

1. Classificar o tipo de arquivo e escolher o disco privado antes de habilitar o upload.
2. Modelar o vínculo de negócio que determina quem pode acessá-lo.
3. Implementar ou ampliar a Policy com a capacidade `view`/`download` e testes de autorização.
4. Criar o endpoint autenticado que autoriza antes de ler o storage.
5. Escolher streaming pelo endpoint ou URL temporária curta conforme o provider e a necessidade de auditoria.
6. Substituir no frontend qualquer URL pública por uma rota de download protegida.
7. Executar o roteiro manual abaixo e revisar LGPD, logs, backup e expiração/revogação.

## Roteiro manual para a futura implementação

1. Envie um arquivo classificado como privado e confirme que ele não existe em `public/storage` nem abre por URL pública.
2. Como usuário autorizado, acesse a rota de download e confirme que o arquivo correto é entregue.
3. Como usuário autenticado sem vínculo, acesse a mesma rota e confirme resposta `403` ou `404`, conforme a política de não divulgação adotada.
4. Remova o vínculo que concede acesso e confirme que um novo download é bloqueado imediatamente.
5. Se houver URL temporária, confirme prazo curto, ausência da URL em logs/respostas persistidas e bloqueio após expiração.
6. Consulte a auditoria e confirme que ela contém somente identificadores técnicos e o resultado do download.

## Fora do escopo desta issue

Este starter não cria agora um disco adicional, migration, rota, controller, Policy nova, URL temporária ou fluxo de upload privado. A implementação deve começar somente quando um produto tiver um caso de uso concreto e puder definir a regra de negócio de acesso.
