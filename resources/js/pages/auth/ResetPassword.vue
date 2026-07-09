<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SeoData } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{ seo: SeoData; token: string; email: string }>();
const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});
</script>

<template>
  <SeoHead :seo="seo" />
  <PublicLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900"
      @submit.prevent="form.post('/reset-password')"
    >
      <h1 class="text-2xl font-bold">Redefinir senha</h1>
      <div>
        <label class="mb-1 block text-sm" for="email">E-mail</label
        ><input
          id="email"
          v-model="form.email"
          type="email"
          required
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password">Nova senha</label
        ><input
          id="password"
          v-model="form.password"
          type="password"
          required
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password_confirmation">Confirmar senha</label
        ><input
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          required
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
      </div>
      <button
        class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-400"
        :disabled="form.processing"
      >
        Salvar nova senha
      </button>
    </form>
  </PublicLayout>
</template>
