# Componentes UI mínimos

Os componentes em `resources/js/components/ui` formam uma base visual reutilizável para telas novas. Eles são intencionalmente simples: mantenha estilos e regras de negócio nas páginas ou no módulo de domínio, sem transformar este diretório em um design system completo.

## Uso

```vue
<script setup lang="ts">
import BaseAlert from '@/components/ui/BaseAlert.vue';
import BaseButton from '@/components/ui/BaseButton.vue';
import BaseCard from '@/components/ui/BaseCard.vue';
import BaseInput from '@/components/ui/BaseInput.vue';
</script>

<template>
  <BaseCard>
    <BaseAlert variant="success" title="Salvo">As alterações foram registradas.</BaseAlert>
    <BaseInput id="name" v-model="name" label="Nome" :error="errors.name" />
    <BaseButton type="submit" :loading="processing">Salvar</BaseButton>
  </BaseCard>
</template>
```

- `BaseButton`: use `variant="primary|secondary|danger|ghost"` e `loading` para desabilitar a ação enquanto processa.
- `BaseInput`: usa `v-model`, exige `id` e `label`, e expõe feedback acessível por `error`.
- `BaseCard`: contêiner visual padrão para blocos de conteúdo.
- `BaseAlert`: feedback com `variant="info|success|warning|error"` e título opcional.
- `EmptyState`: conteúdo vazio com título, descrição e slot nomeado `action` opcional.
- `LoadingState`: indicador semântico para carregamentos de página ou seção.

Para links que precisam de aparência de botão, mantenha `Link`/`a` explícito na página. Isso evita misturar navegação e ações de formulário no componente base.
