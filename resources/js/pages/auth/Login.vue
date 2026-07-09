<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SeoData } from '@/types';
import { useForm } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const form = useForm({ email: '', password: '', remember: false });
</script>

<template>
  <SeoHead :seo="seo" />
  <PublicLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900"
      @submit.prevent="form.post('/login')"
    >
      <h1 class="text-2xl font-bold">Entrar</h1>
      <div>
        <label class="mb-1 block text-sm" for="email">E-mail</label
        ><input
          id="email"
          v-model="form.email"
          type="email"
          required
          autocomplete="email"
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
        <p v-if="form.errors.email" class="text-sm text-red-700 dark:text-red-300">
          {{ form.errors.email }}
        </p>
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password">Senha</label
        ><input
          id="password"
          v-model="form.password"
          type="password"
          required
          autocomplete="current-password"
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
      </div>
      <label class="flex gap-2 text-sm"
        ><input v-model="form.remember" type="checkbox" /> Lembrar de mim</label
      >
      <button
        class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-400"
        :disabled="form.processing"
      >
        Entrar
      </button>
    </form>
  </PublicLayout>
</template>
