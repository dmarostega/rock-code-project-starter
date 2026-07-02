<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { SeoData } from '@/types';
import { useForm } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const form = useForm({ email: '' });
</script>

<template>
  <SeoHead :seo="seo" />
  <AppLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border bg-white p-6"
      @submit.prevent="form.post('/forgot-password')"
    >
      <h1 class="text-2xl font-bold">Recuperar senha</h1>
      <p class="text-sm text-slate-600">Enviaremos um link de redefinição para seu e-mail.</p>
      <div>
        <label class="mb-1 block text-sm" for="email">E-mail</label
        ><input
          id="email"
          v-model="form.email"
          type="email"
          required
          class="w-full rounded-lg border px-3 py-2"
        />
        <p v-if="form.errors.email" class="text-sm text-red-700">{{ form.errors.email }}</p>
      </div>
      <button
        class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white"
        :disabled="form.processing"
      >
        Enviar link
      </button>
    </form>
  </AppLayout>
</template>
