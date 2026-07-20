<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { SeoData } from '@/types';

defineProps<{ seo: SeoData }>();
</script>

<template>
  <SeoHead :seo="seo" />
  <AdminLayout>
    <section class="max-w-3xl">
      <p class="text-sm font-semibold tracking-wide text-blue-700 uppercase dark:text-blue-300">
        Administração
      </p>
      <h1 class="mt-2 text-3xl font-bold">Painel administrativo</h1>
      <p class="mt-3 text-slate-600 dark:text-slate-300">
        Esta é a fundação protegida para fluxos administrativos futuros. Inclua apenas as
        capacidades necessárias ao produto derivado, com autorização específica para cada uma.
      </p>
    </section>
  </AdminLayout>
</template>
