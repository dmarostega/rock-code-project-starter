<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import { useGrowth } from '@/composables/useGrowth';
import AppLayout from '@/layouts/AppLayout.vue';
import type { SeoData } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const { track } = useGrowth();
</script>

<template>
  <SeoHead :seo="seo" />
  <AppLayout>
    <section class="py-20 text-center">
      <p class="mb-3 text-sm font-semibold tracking-widest text-blue-700 uppercase">Rock Code Starter</p>
      <h1 class="mx-auto max-w-3xl text-4xl font-bold tracking-tight sm:text-6xl">Uma base limpa para o próximo produto.</h1>
      <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-600">Laravel, Inertia e Vue com TypeScript, autenticação, SEO, growth e mídia prontos para evoluir.</p>
      <Link href="/register" class="mt-8 inline-block rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white" @click="track({ name: 'cta.register.clicked', metadata: { placement: 'hero' } })">Começar</Link>
    </section>
  </AppLayout>
</template>
