<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SeoData } from '@/types';
import { useForm } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const form = useForm({ name: '', email: '', password: '', password_confirmation: '' });
</script>

<template>
  <SeoHead :seo="seo" />
  <PublicLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900"
      @submit.prevent="form.post('/register')"
    >
      <h1 class="text-2xl font-bold">Criar conta</h1>
      <div v-for="field in ['name', 'email'] as const" :key="field">
        <label class="mb-1 block text-sm" :for="field">{{
          field === 'name' ? 'Nome' : 'E-mail'
        }}</label
        ><input
          :id="field"
          v-model="form[field]"
          :type="field === 'email' ? 'email' : 'text'"
          required
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
        <p v-if="form.errors[field]" class="text-sm text-red-700 dark:text-red-300">
          {{ form.errors[field] }}
        </p>
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password">Senha</label
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
        Criar conta
      </button>
    </form>
  </PublicLayout>
</template>
