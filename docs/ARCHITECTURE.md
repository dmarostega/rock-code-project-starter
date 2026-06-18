# Arquitetura

## Princípios

- O starter fornece infraestrutura, não regras de um produto específico.
- Controllers coordenam HTTP; validação fica em Form Requests e regras ficam em Services/Actions.
- Autorização de recursos pertence a Policies.
- O frontend é integralmente TypeScript e páginas Inertia devem permanecer pequenas.

## Módulos opcionais

### SEO

`App\Support\Seo\SeoData` normaliza title, description, canonical, Open Graph e Twitter Card. Cada página entrega a prop `seo` e `SeoHead.vue` publica as tags. O sitemap inicial é intencionalmente simples e deve passar a usar URLs reais do produto.

### Growth

`CaptureGrowthAttribution` guarda UTMs na sessão e `GrowthTracker` persiste eventos first-party. IP nunca é persistido em claro. Antes da produção, documente consentimento, revise retenção e defina a taxonomia dos eventos.

### Media

`MediaService` aceita imagens e PDF. Imagens são redimensionadas e regravadas em WebP, removendo metadados do arquivo original. O disco, limite e qualidade são configuráveis. Para arquivos privados, troque o disco e entregue URLs temporárias por endpoint autorizado.

## Remoção

Cada módulo pode ser removido excluindo suas classes, migration, config, rotas e testes correspondentes. Não há dependência de negócio entre SEO, Growth e Media.
