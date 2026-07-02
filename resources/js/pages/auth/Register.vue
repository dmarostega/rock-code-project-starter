<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { SeoData } from '@/types';
import { useForm } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const form = useForm({ name: '', email: '', password: '', password_confirmation: '' });
</script>

<template>
  <SeoHead :seo="seo" />
  <AppLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border bg-white p-6"
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
          class="w-full rounded-lg border px-3 py-2"
        />
        <p v-if="form.errors[field]" class="text-sm text-red-700">{{ form.errors[field] }}</p>
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password">Senha</label
        ><input
          id="password"
          v-model="form.password"
          type="password"
          required
          class="w-full rounded-lg border px-3 py-2"
        />
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password_confirmation">Confirmar senha</label
        ><input
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          required
          class="w-full rounded-lg border px-3 py-2"
        />
      </div>
      <button
        class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white"
        :disabled="form.processing"
      >
        Criar conta
      </button>
    </form>
  </AppLayout>
</template>
