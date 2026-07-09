<script setup lang="ts">
import ThemeToggle from '@/components/ThemeToggle.vue';
import type { PageProps } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage<PageProps>();
</script>

<template>
  <div class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <header
      class="border-b border-slate-200 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90"
    >
      <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <Link href="/" class="font-semibold text-slate-950 dark:text-white">
          {{ page.props.appName }}
        </Link>
        <div class="flex items-center gap-4 text-sm">
          <ThemeToggle />
          <Link
            href="/login"
            class="font-medium text-slate-700 hover:text-blue-700 dark:text-slate-200 dark:hover:text-blue-300"
          >
            Entrar
          </Link>
          <Link
            href="/register"
            class="rounded-lg bg-blue-600 px-3 py-2 font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
          >
            Criar conta
          </Link>
        </div>
      </nav>
    </header>
    <main class="mx-auto max-w-6xl px-6 py-10"><slot /></main>
  </div>
</template>
