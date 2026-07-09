<script setup lang="ts">
import type { PageProps } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage<PageProps>();
</script>

<template>
  <div class="min-h-screen bg-slate-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white">
      <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <Link href="/" class="font-semibold">{{ page.props.appName }}</Link>
        <div class="flex items-center gap-4 text-sm">
          <Link href="/login">Entrar</Link>
          <Link href="/register" class="rounded-lg bg-blue-600 px-3 py-2 font-semibold text-white">
            Criar conta
          </Link>
        </div>
      </nav>
    </header>
    <main class="mx-auto max-w-6xl px-6 py-10"><slot /></main>
  </div>
</template>
