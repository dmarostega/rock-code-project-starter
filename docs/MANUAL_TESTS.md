# Roteiro manual da v0.1

## Flags de recurso

1. Defina `APP_FLAG_MEDIA_UPLOADS=false`, limpe o cache de configuracao e confirme que `POST /media` retorna 404 mesmo para um usuario autenticado.
2. Reative a flag e confirme que o upload volta a funcionar.

> Quando o produto implementar arquivos privados, execute também o roteiro de [download protegido](PRIVATE_FILE_DOWNLOAD_PATTERN.md). O módulo atual permanece configurado apenas para mídia pública.

Use este roteiro antes de marcar o starter como base experimental v0.1 ou antes de adotar o repositório em um novo produto.

## 1. Setup limpo

1. Clone o repositório em uma pasta nova.
2. Copie `.env.example` para `.env`, mantendo os padrões locais.
3. Confirme que `APP_ENV=local`, `APP_DEBUG=true`, `DB_CONNECTION=sqlite`, `GROWTH_ENABLED=false`, `GA_ENABLED=false` e `GA_MEASUREMENT_ID=` estão definidos.
4. Execute `composer setup`.
5. Confirme que `database/database.sqlite` foi criado e que as migrations rodaram sem erro.
6. Execute `php artisan storage:link`.
7. Execute `composer dev` e abra `http://localhost:8000` ou a URL exibida pelo servidor.
8. Confirme que a home carrega sem erro no console do navegador.
9. Acesse `/up` e confirme resposta HTTP 200.
10. Abra a home e `/login` em uma aba anônima e confirme que a aba exibe o ícone de `public/favicon.svg`; limpe o cache se necessário.

## 2. Autenticação

1. Acesse `/register`, crie uma conta com nome, e-mail e senha válidos.
2. Confirme o redirecionamento para `/dashboard`.
3. Confirme que o dashboard exibe navegação autenticada com link para dashboard e ação de sair.
4. Saia da conta.
5. Confirme que a home, login, cadastro e reset de senha exibem somente navegação pública.
6. Acesse `/login` com a conta criada e confirme novo acesso ao dashboard.
7. Tente acessar `/dashboard` sem sessão e confirme redirecionamento para `/login`.
8. Tente enviar `POST /media` sem sessão e confirme redirecionamento ou resposta de não autorizado.
9. Tente entrar com credenciais inválidas e confirme a mensagem amigável `As credenciais informadas não conferem.`, sem exibir `auth.failed`.
10. Entre com credenciais válidas sem marcar `Lembrar de mim`; confirme que a sessão segue o comportamento normal.
11. Saia, entre novamente marcando `Lembrar de mim` e confirme a presença do cookie persistente em uma nova sessão do navegador.

## 2.1 Perfil do usuário

1. Acesse `/profile` sem sessão e confirme redirecionamento para `/login`.
2. Entre com uma conta válida e acesse `/profile` pela navegação autenticada.
3. Confirme que nome, e-mail e referência para redefinição de senha aparecem na tela.
4. Altere o nome e salve; confirme a mensagem de sucesso e o novo nome na navegação.
5. Tente salvar nome vazio e confirme a mensagem de validação.

## 2.2 Administração mínima

1. Com `ADMIN_EMAILS` vazio, autentique um usuário e confirme que `/admin` retorna 403.
2. Defina o e-mail da conta em `ADMIN_EMAILS`, reinicie a aplicação ou limpe o cache de configuração e confirme o acesso a `/admin`.
3. Confirme que a tela usa o layout administrativo e possui o link de retorno ao dashboard.
4. Remova o e-mail de `ADMIN_EMAILS` e confirme que o acesso volta a ser bloqueado.

## 2.3 Auditoria mínima

1. Com `ADMIN_EMAILS` configurado, acesse `/admin` com uma conta autorizada.
2. Consulte `audit_logs` e confirme um registro `admin.accessed` com o `actor_id` técnico da conta.
3. Confirme que o registro não contém nome, e-mail, senha, token ou outro conteúdo da requisição.

## 2.4 Tema claro/escuro

1. Limpe `localStorage.rock-code-theme` e carregue a home com o sistema em tema claro; confirme que o layout inicia claro.
2. Repita sem preferência salva com o sistema em tema escuro; confirme que a classe `dark` aparece no elemento `html`.
3. Use o botão de tema na home e confirme alternância entre light e dark.
4. Recarregue a página e confirme que a escolha manual permanece salva no navegador.
5. Acesse `/login`, `/register`, `/forgot-password`, `/reset-password` e `/dashboard`; confirme texto, campos, botões e cards legíveis nos dois temas.

## 3. Reset de senha

1. Confirme que `MAIL_MAILER=log` está configurado no ambiente local.
2. Acesse `/forgot-password` e solicite reset para o e-mail cadastrado.
3. Abra `storage/logs/laravel.log` e localize o link de reset gerado.
4. Acesse o link, defina uma nova senha e confirme o redirecionamento esperado.
5. Saia da conta e entre novamente usando a nova senha.
6. Confirme que a senha antiga não autentica mais.

## 4. Upload e storage

1. Acesse o dashboard autenticado.
2. Envie arquivos JPG, PNG, WebP e PDF válidos.
3. Confirme que os arquivos aparecem na listagem do dashboard.
4. Confirme que imagens grandes são convertidas para WebP e respeitam `MEDIA_IMAGE_MAX_WIDTH`.
5. Envie um arquivo inválido, como `.txt` ou imagem corrompida, e confirme que o upload é recusado com mensagem clara.
6. Envie um arquivo acima de `MEDIA_MAX_SIZE_KB` e confirme que o upload é recusado.
7. Confirme que `MEDIA_DISK=public` grava arquivos no disco público e que a URL pública funciona para arquivos não sensíveis.
8. Revise se o produto derivado realmente pode usar storage público. Para arquivos sensíveis, troque para disco privado e implemente entrega autorizada ou URL temporária antes da adoção.
9. Com dois usuários diferentes, confirme que um usuário não consegue excluir mídia pertencente ao outro.

10. Confirme que `MEDIA_IMAGE_DRIVER` aponta para um driver suportado, como `Intervention\Image\Drivers\Gd\Driver`; se o ambiente nao tiver capacidade para processar a imagem, o upload deve preservar o arquivo original validado.

11. Inicie o ambiente com `composer dev`; ele configura o servidor PHP para upload de imagem de ate 10 MB. Confirme que a URL devolvida para a midia comeca com `/storage/` e abre no mesmo host e porta do dashboard. No Windows, use `dev:logs` somente se o ambiente tiver a extensao `pcntl`; o Pail foi separado do comando principal por essa dependencia.

12. Envie uma imagem corrompida com MIME ou extensao permitidos e confirme resposta controlada, sem criar midia ou armazenar arquivo.

## 5. SEO

1. Abra a home e inspecione o HTML renderizado.
2. Confirme `title`, `description`, `canonical`, Open Graph e Twitter Card.
3. Acesse `/sitemap.xml` e confirme que somente páginas públicas indexáveis de `APP_SEO_SITEMAP_PATHS` aparecem.
4. Confirme que `/login`, `/register`, `/forgot-password`, `/reset-password`, `/dashboard`, `/admin`, `/profile` e `/settings` não aparecem no sitemap.
5. Acesse `/robots.txt` com o `.env.example` padrão e confirme que ele exibe apenas `User-agent: *` e `Sitemap: ...`, sem `Disallow`.
6. Inspecione `/login`, `/register`, `/forgot-password`, um link de `/reset-password`, `/dashboard` e `/profile`; confirme `<meta name="robots" content="noindex,nofollow">`.
7. Para novas telas privadas como settings ou admin, confirme que o controller usa `SeoData::privatePage()`.
8. Ao adicionar uma nova página pública, inclua seu caminho em `APP_SEO_SITEMAP_PATHS`; não adicione telas autenticadas, operacionais ou de reset de senha.
9. Confirme que `APP_SEO_DEFAULT_TITLE`, `APP_SEO_TITLE_SUFFIX`, `APP_SEO_DEFAULT_DESCRIPTION`, `APP_SEO_DEFAULT_IMAGE`, `APP_SEO_TWITTER_CARD`, `APP_SEO_ROBOTS`, `APP_SEO_SITEMAP_PATHS` e `APP_SEO_ROBOTS_DISALLOW` foram revisados no `.env` do produto.
10. Para produtos públicos, confirme que `APP_SEO_DEFAULT_IMAGE` aponta para uma imagem social pública, absoluta e acessível sem login.

## 5.1 Páginas de erro e manutenção

1. Acesse uma URL inexistente e confirme a página 404 com retorno HTTP 404.
2. Com um usuário sem permissão de admin, acesse `/admin` e confirme a página 403 com retorno HTTP 403.
3. Acesse `/maintenance` e confirme a página de manutenção, sem configurar o modo de manutenção da aplicação.
4. Inspecione as páginas 403, 404 e manutenção e confirme `<meta name="robots" content="noindex,nofollow">`.

## 5.2 Configurações gerais do aplicativo

1. Confirme que `APP_PUBLIC_NAME` aparece na navegação pública e autenticada.
2. Confirme que `APP_CONTACT_NAME`, `APP_CONTACT_EMAIL`, `APP_CONTACT_PHONE` e `APP_CONTACT_URL` foram revisados para o produto derivado e contêm apenas dados públicos.
3. Confirme que `APP_FLAG_PUBLIC_REGISTRATION`, `APP_FLAG_MEDIA_UPLOADS` e `GROWTH_ENABLED` refletem a decisão inicial do produto.
4. Confirme que nenhuma tela administrativa complexa foi adicionada para essas configurações neste ciclo.

## 5.3 Blueprint de planos e feature access

1. Antes de adicionar billing, defina no produto derivado uma matriz plano × feature × limite, incluindo os estados `free`, `trial` e `premium` que forem aplicáveis.
2. Confirme que cada rota, action, job e endpoint premium consulta uma decisão server-side; ocultar a ação no frontend não é suficiente.
3. Teste uma conta ou organização sem entitlement e confirme o bloqueio esperado; teste um entitlement ativo, um trial expirado e um grant manual revogado. Confirme também que não é possível consultar, conceder ou consumir recursos de outro usuário ou organização por identificador direto.
4. Para um recurso limitado, execute requisições concorrentes e confirme que o limite não é ultrapassado nem consumido duas vezes por retry.
5. Se houver gateway, envie um webhook com assinatura ausente, inválida ou timestamp fora da tolerância e confirme que ele é rejeitado antes de idempotência, reconciliação ou alteração de entitlement. Confirme que o segredo permanece apenas no servidor e possui processo de rotação.
6. Com um evento autenticado, confirme que o webhook idempotente atualiza entitlements somente uma vez e não concede acesso diretamente sem a decisão central.

## 6. Growth e GA4

1. Com o `.env.example` padrão, abra a home em `http://localhost`.
2. No Network do navegador, confirme que não há requests para `googletagmanager.com` nem `analytics.google.com/g/collect`.
3. Confirme que `POST /growth/events` retorna 403 com `GROWTH_ENABLED=false`.
4. Habilite `GROWTH_ENABLED=true` e `VITE_GROWTH_ENABLED=true`.
5. Acesse `/?utm_source=manual&utm_campaign=starter`, clique em "Começar" e confirme o registro do evento em `growth_events`.
6. Confirme que o evento não persiste IP em claro.
7. Antes de habilitar Growth em um produto derivado, siga `docs/ANALYTICS_EVENT_TAXONOMY.md`, revise a allowlist positiva e confirme que eventos, chaves e valores fora da taxonomia são recusados.
8. Confirme que metadata com chaves sensíveis, objetos aninhados ou strings longas é recusada.
9. Em ambiente de produção controlado, configure `GA_ENABLED=true`, `GA_MEASUREMENT_ID=G-XXXXXXXXXX` e `APP_DEBUG=false`.
10. Confirme que a tag GA4 aparece apenas em host público e nunca em local, debug ou sem measurement id.

## 7. Qualidade e CI

1. Execute `composer ci:check`.
2. Execute `npm run quality`.
3. Corrija falhas antes de promover a base para v0.1 ou derivar um produto.

## 7.1 Componentes UI mínimos

1. Acesse `/login` e confirme que card, campo de e-mail e botão mantêm contraste e foco visível nos temas claro e escuro.
2. Envie o formulário com um e-mail inválido e confirme que o feedback do campo é exibido e associado ao input.
3. Em uma tela de desenvolvimento, valide `BaseAlert` nas quatro variantes, `EmptyState` com e sem ação e `LoadingState` com leitor de tela ou inspeção do atributo `role="status"`.

## 8. Registro final

1. Registre ambiente, data, branch, commit e comandos executados.
2. Registre quais módulos opcionais serão mantidos ou removidos no produto derivado.
3. Registre qualquer exceção aceita para storage, analytics, SEO ou autenticação.
