<script setup lang="ts">
import BaseAlert from '@/components/ui/BaseAlert.vue';
import SeoHead from '@/components/SeoHead.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SeoData } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
const form = useForm({ email: '' });
const page = usePage<{ flash: { status?: string } }>();
</script>

<template>
  <SeoHead :seo="seo" />
  <PublicLayout>
    <form
      class="mx-auto max-w-md space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900"
      @submit.prevent="form.post('/forgot-password')"
    >
      <h1 class="text-2xl font-bold">Recuperar senha</h1>
      <BaseAlert v-if="page.props.flash.status" variant="success">
        {{ page.props.flash.status }}
      </BaseAlert>
      <p class="text-sm text-slate-600 dark:text-slate-300">
        Enviaremos um link de redefinição para seu e-mail.
      </p>
      <div>
        <label class="mb-1 block text-sm" for="email">E-mail</label
        ><input
          id="email"
          v-model="form.email"
          type="email"
          required
          class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        />
        <p v-if="form.errors.email" class="text-sm text-red-700 dark:text-red-300">
          {{ form.errors.email }}
        </p>
      </div>
      <button
        class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-400"
        :disabled="form.processing"
      >
        Enviar link
      </button>
    </form>
  </PublicLayout>
</template>
