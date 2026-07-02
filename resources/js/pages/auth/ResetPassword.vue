<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
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
  <AppLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border bg-white p-6"
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
          class="w-full rounded-lg border px-3 py-2"
        />
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password">Nova senha</label
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
        Salvar nova senha
      </button>
    </form>
  </AppLayout>
</template>
