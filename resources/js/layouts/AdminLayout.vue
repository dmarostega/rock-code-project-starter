<script setup lang="ts">
import ThemeToggle from '@/components/ThemeToggle.vue';
import type { PageProps } from '@/types';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage<PageProps>();

const logout = (): void => router.post('/logout');
</script>

<template>
  <div class="min-h-screen bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
      <nav class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-4 sm:px-6">
        <div class="flex min-w-0 items-center gap-3 sm:gap-5">
          <Link href="/admin" class="truncate font-semibold text-slate-950 dark:text-white">
            {{ page.props.appName }} · Admin
          </Link>
          <Link
            href="/dashboard"
            class="text-sm font-medium text-blue-700 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200"
          >
            Voltar ao produto
          </Link>
        </div>
        <div class="flex shrink-0 items-center gap-2 text-sm sm:gap-4">
          <ThemeToggle />
          <span class="hidden text-slate-600 sm:inline dark:text-slate-300">
            {{ page.props.auth.user?.name }}
          </span>
          <button
            type="button"
            class="font-medium text-slate-700 hover:text-blue-700 dark:text-slate-200 dark:hover:text-blue-300"
            @click="logout"
          >
            Sair
          </button>
        </div>
      </nav>
    </header>
    <main class="mx-auto max-w-6xl px-6 py-10"><slot /></main>
  </div>
</template>
