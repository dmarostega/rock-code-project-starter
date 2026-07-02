<script setup lang="ts">
import type { PageProps } from '@/types';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<PageProps>();
const user = computed(() => page.props.auth.user);
const logout = (): void => router.post('/logout');
</script>

<template>
  <div class="min-h-screen bg-slate-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white">
      <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <Link href="/" class="font-semibold">{{ page.props.appName }}</Link>
        <div class="flex items-center gap-4 text-sm">
          <template v-if="user">
            <Link href="/dashboard">Dashboard</Link>
            <button type="button" @click="logout">Sair</button>
          </template>
          <template v-else>
            <Link href="/login">Entrar</Link>
            <Link href="/register">Criar conta</Link>
          </template>
        </div>
      </nav>
    </header>
    <main class="mx-auto max-w-6xl px-6 py-10"><slot /></main>
  </div>
</template>
