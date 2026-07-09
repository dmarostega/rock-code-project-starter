<script setup lang="ts">
import type { PageProps } from '@/types';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage<PageProps>();
const logout = (): void => router.post('/logout');
</script>

<template>
  <div class="min-h-screen bg-slate-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white">
      <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <div class="flex items-center gap-5">
          <Link href="/" class="font-semibold">{{ page.props.appName }}</Link>
          <Link href="/dashboard" class="text-sm font-medium text-blue-700">Dashboard</Link>
        </div>
        <div class="flex items-center gap-4 text-sm">
          <span v-if="page.props.auth.user" class="hidden text-slate-600 sm:inline">
            {{ page.props.auth.user.name }}
          </span>
          <button type="button" class="font-medium text-slate-700" @click="logout">Sair</button>
        </div>
      </nav>
    </header>
    <main class="mx-auto max-w-6xl px-6 py-10"><slot /></main>
  </div>
</template>
