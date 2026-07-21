<script setup lang="ts">
import ErrorPage from '@/components/ErrorPage.vue';
import SeoHead from '@/components/SeoHead.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SeoData } from '@/types';

defineProps<{ seo: SeoData }>();
</script>

<template>
  <SeoHead :seo="seo" />
  <PublicLayout>
    <ErrorPage
      code="419"
      title="Página expirada"
      description="Sua sessão expirou. Atualize a página e tente novamente."
      :action="{ label: 'Atualizar página', href: '' }"
    />
  </PublicLayout>
</template>
