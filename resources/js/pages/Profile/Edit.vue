<script setup lang="ts">
import SeoHead from '@/components/SeoHead.vue';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import type { PageProps, SeoData } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();

const page = usePage<PageProps>();
const user = page.props.auth.user;
const form = useForm({
  name: user?.name ?? '',
});
</script>

<template>
  <SeoHead :seo="seo" />
  <AuthenticatedLayout>
    <div class="mx-auto max-w-3xl space-y-8">
      <section>
        <h1 class="text-3xl font-bold">Meu perfil</h1>
        <p class="mt-2 text-slate-600 dark:text-slate-300">
          Revise os dados basicos da conta e mantenha seu nome atualizado.
        </p>
      </section>

      <form
        class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900"
        @submit.prevent="form.patch('/profile')"
      >
        <div
          v-if="page.props.flash.success"
          class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 dark:bg-green-950 dark:text-green-200"
        >
          {{ page.props.flash.success }}
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium" for="name">Nome</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
          />
          <p v-if="form.errors.name" class="mt-1 text-sm text-red-700 dark:text-red-300">
            {{ form.errors.name }}
          </p>
        </div>

        <div>
          <span class="mb-1 block text-sm font-medium">E-mail</span>
          <p
            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-700 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300"
          >
            {{ user?.email }}
          </p>
        </div>

        <div
          class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300"
        >
          <h2 class="font-semibold text-slate-950 dark:text-white">Senha</h2>
          <p class="mt-1">A troca de senha usa o fluxo de redefinicao ja disponivel no starter.</p>
        </div>

        <button
          class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-400"
          :disabled="form.processing"
        >
          Salvar perfil
        </button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
