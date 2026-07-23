<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import { useGrowth } from '@/composables/useGrowth';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { PageProps, SeoData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const { track } = useGrowth();
const page = usePage<PageProps>();
</script>

<template>
  <SeoHead :seo="seo" />
  <PublicLayout>
    <section class="py-20 text-center">
      <p
        class="mb-3 text-sm font-semibold tracking-widest text-blue-700 uppercase dark:text-blue-300"
      >
        Rock Code Starter
      </p>
      <h1 class="mx-auto max-w-3xl text-4xl font-bold tracking-tight sm:text-6xl">
        Uma base limpa para o próximo produto.
      </h1>
      <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-600 dark:text-slate-300">
        Laravel, Inertia e Vue com TypeScript, autenticação, SEO, growth e mídia prontos para
        evoluir.
      </p>
      <Link
        v-if="!page.props.auth.user && page.props.appSettings.flags.public_registration"
        href="/register"
        class="mt-8 inline-block rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
        @click="track({ name: 'cta.clicked', metadata: { cta_id: 'register', placement: 'hero' } })"
        >Começar</Link
      >
    </section>
  </PublicLayout>
</template>
