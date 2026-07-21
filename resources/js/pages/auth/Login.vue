<script setup lang="ts">
import BaseButton from '@/components/ui/BaseButton.vue';
import BaseCard from '@/components/ui/BaseCard.vue';
import BaseInput from '@/components/ui/BaseInput.vue';
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
    <BaseCard class="mx-auto max-w-md">
      <form class="space-y-4" @submit.prevent="form.post('/login')">
        <h1 class="text-2xl font-bold">Entrar</h1>
        <BaseInput
          id="email"
          v-model="form.email"
          type="email"
          label="E-mail"
          required
          autocomplete="email"
          :error="form.errors.email"
        />
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
        <BaseButton type="submit" class="w-full" :loading="form.processing"> Entrar </BaseButton>
      </form>
    </BaseCard>
  </PublicLayout>
</template>
