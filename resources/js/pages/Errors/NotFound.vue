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
      code="404"
      title="Página não encontrada"
      description="O endereço informado não existe ou pode ter sido movido."
    />
  </PublicLayout>
</template>
