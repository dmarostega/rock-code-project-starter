<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { SeoData } from '@/types';
import { useForm } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const form = useForm({ email: '', password: '', remember: false });
</script>

<template>
  <SeoHead :seo="seo" />
  <AppLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border bg-white p-6"
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
          class="w-full rounded-lg border px-3 py-2"
        />
        <p v-if="form.errors.email" class="text-sm text-red-700">{{ form.errors.email }}</p>
      </div>
      <div>
        <label class="mb-1 block text-sm" for="password">Senha</label
        ><input
          id="password"
          v-model="form.password"
          type="password"
          required
          autocomplete="current-password"
          class="w-full rounded-lg border px-3 py-2"
        />
      </div>
      <label class="flex gap-2 text-sm"
        ><input v-model="form.remember" type="checkbox" /> Lembrar de mim</label
      >
      <button
        class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white"
        :disabled="form.processing"
      >
        Entrar
      </button>
    </form>
  </AppLayout>
</template>
