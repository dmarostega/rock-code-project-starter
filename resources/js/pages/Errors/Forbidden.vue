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
      code="403"
      title="Acesso não autorizado"
      description="Você não tem permissão para acessar esta página."
    />
  </PublicLayout>
</template>
