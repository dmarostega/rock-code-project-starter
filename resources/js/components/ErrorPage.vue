<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
  code: string;
  title: string;
  description: string;
  action?: {
    label: string;
    href: string;
  };
}>();
</script>

<template>
  <section
    class="mx-auto flex min-h-[60vh] max-w-2xl items-center justify-center py-12 text-center"
  >
    <div>
      <p class="text-sm font-semibold tracking-widest text-blue-700 uppercase dark:text-blue-300">
        Erro {{ code }}
      </p>
      <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">{{ title }}</h1>
      <p class="mx-auto mt-5 max-w-xl text-lg text-slate-600 dark:text-slate-300">
        {{ description }}
      </p>
      <Link
        :href="action?.href ?? '/'"
        class="mt-8 inline-block rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
      >
        {{ action?.label ?? 'Voltar para o início' }}
      </Link>
    </div>
  </section>
</template>
