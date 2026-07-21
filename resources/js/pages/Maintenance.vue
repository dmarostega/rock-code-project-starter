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
      code=""
      title="Estamos em manutenção"
      description="Estamos fazendo melhorias. Volte em breve para continuar usando o produto."
    />
  </PublicLayout>
</template>
