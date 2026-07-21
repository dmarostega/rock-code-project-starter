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
      code="500"
      title="Erro interno"
      description="Não foi possível concluir sua solicitação. Tente novamente em alguns instantes."
    />
  </PublicLayout>
</template>
