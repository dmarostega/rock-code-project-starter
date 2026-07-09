# Arquitetura

## Princípios

- O starter fornece infraestrutura, não regras de um produto específico.
- Controllers coordenam HTTP; validação fica em Form Requests e regras ficam em Services/Actions.
- Autorização de recursos pertence a Policies.
- O frontend é integralmente TypeScript e páginas Inertia devem permanecer pequenas.

## Módulos opcionais

### SEO

`config/app_settings.php` concentra a fundação reaproveitável de configurações públicas: nome visível, contato principal, SEO default revisável e flags simples. `App\Support\Seo\SeoData` usa essa fundação para normalizar title, description, canonical, Open Graph e Twitter Card. Cada página entrega a prop `seo` e `SeoHead.vue` publica as tags. Use `SeoData::page()` somente em páginas públicas indexáveis. Use `SeoData::privatePage()` em auth, dashboard, profile, settings, admin e qualquer tela restrita ou operacional para publicar `noindex,nofollow`. O sitemap inicial é intencionalmente simples e deve passar a usar URLs reais do produto.

### Growth

`CaptureGrowthAttribution` guarda UTMs na sessão e `GrowthTracker` persiste eventos first-party. IP nunca é persistido em claro. Antes da produção, documente consentimento, revise retenção e defina a taxonomia dos eventos.

### Media

`MediaService` aceita imagens e PDF. Imagens são redimensionadas e regravadas em WebP, removendo metadados do arquivo original. O disco, limite e qualidade são configuráveis.

Padrão recomendado:

- `MEDIA_DISK=public` é aceitável para arquivos públicos, como imagens de perfil, thumbnails, fotos de produtos e documentos que devem estar acessíveis por URL sem autorização específica.
- Troque para disco privado quando o arquivo tiver restrição de acesso, como documentos com dados pessoais, contratos, faturas, relatórios internos, arquivos médicos/legais ou qualquer conteúdo que não deva ser alcançável por URL pública.
- Arquivos sensíveis nunca devem ficar em storage público. Mesmo quando o arquivo não é listado, a URL pode ser compartilhada, indexada ou adivinhada; o padrão seguro é usar disco privado e entregar acesso por endpoint autorizado ou URL temporária.
- Em novos produtos, defina essa política no início do projeto: público para conteúdo aberto e privado para conteúdo restrito. A evolução futura de download protegido para discos privados pode ser tratada como pendência P1/P2.

## Remoção

Cada módulo pode ser removido excluindo suas classes, migration, config, rotas e testes correspondentes. Não há dependência de negócio entre SEO, Growth e Media.
