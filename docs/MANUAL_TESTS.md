# Roteiro manual da v0.1

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

## 2. Autenticação

1. Acesse `/register`, crie uma conta com nome, e-mail e senha válidos.
2. Confirme o redirecionamento para `/dashboard`.
3. Confirme que o dashboard exibe navegação autenticada com link para dashboard e ação de sair.
4. Saia da conta.
5. Confirme que a home, login, cadastro e reset de senha exibem somente navegação pública.
6. Acesse `/login` com a conta criada e confirme novo acesso ao dashboard.
7. Tente acessar `/dashboard` sem sessão e confirme redirecionamento para `/login`.
8. Tente enviar `POST /media` sem sessão e confirme redirecionamento ou resposta de não autorizado.
9. Valide mensagens de erro para credenciais inválidas no login.

## 2.1 Perfil do usuário

1. Acesse `/profile` sem sessão e confirme redirecionamento para `/login`.
2. Entre com uma conta válida e acesse `/profile` pela navegação autenticada.
3. Confirme que nome, e-mail e referência para redefinição de senha aparecem na tela.
4. Altere o nome e salve; confirme a mensagem de sucesso e o novo nome na navegação.
5. Tente salvar nome vazio e confirme a mensagem de validação.

## 2.2 Tema claro/escuro

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

## 5.1 Configurações gerais do aplicativo

1. Confirme que `APP_PUBLIC_NAME` aparece na navegação pública e autenticada.
2. Confirme que `APP_CONTACT_NAME`, `APP_CONTACT_EMAIL`, `APP_CONTACT_PHONE` e `APP_CONTACT_URL` foram revisados para o produto derivado e contêm apenas dados públicos.
3. Confirme que `APP_FLAG_PUBLIC_REGISTRATION`, `APP_FLAG_MEDIA_UPLOADS` e `GROWTH_ENABLED` refletem a decisão inicial do produto.
4. Confirme que nenhuma tela administrativa complexa foi adicionada para essas configurações neste ciclo.

## 6. Growth e GA4

1. Com o `.env.example` padrão, abra a home em `http://localhost`.
2. No Network do navegador, confirme que não há requests para `googletagmanager.com` nem `analytics.google.com/g/collect`.
3. Confirme que `POST /growth/events` retorna 403 com `GROWTH_ENABLED=false`.
4. Habilite `GROWTH_ENABLED=true` e `VITE_GROWTH_ENABLED=true`.
5. Acesse `/?utm_source=manual&utm_campaign=starter`, clique em "Começar" e confirme o registro do evento em `growth_events`.
6. Confirme que o evento não persiste IP em claro.
7. Confirme que metadata com chaves sensíveis, objetos aninhados ou strings longas é recusada.
8. Em ambiente de produção controlado, configure `GA_ENABLED=true`, `GA_MEASUREMENT_ID=G-XXXXXXXXXX` e `APP_DEBUG=false`.
9. Confirme que a tag GA4 aparece apenas em host público e nunca em local, debug ou sem measurement id.

## 7. Qualidade e CI

1. Execute `composer ci:check`.
2. Execute `npm run quality`.
3. Corrija falhas antes de promover a base para v0.1 ou derivar um produto.

## 8. Registro final

1. Registre ambiente, data, branch, commit e comandos executados.
2. Registre quais módulos opcionais serão mantidos ou removidos no produto derivado.
3. Registre qualquer exceção aceita para storage, analytics, SEO ou autenticação.
