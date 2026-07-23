<script setup lang="ts">
import BaseButton from '@/components/ui/BaseButton.vue';
import BaseCard from '@/components/ui/BaseCard.vue';
import BaseInput from '@/components/ui/BaseInput.vue';
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
    <BaseCard class="mx-auto max-w-md">
      <form class="space-y-4" @submit.prevent="form.post('/forgot-password')">
        <h1 class="text-2xl font-bold">Recuperar senha</h1>
        <BaseAlert v-if="page.props.flash.status" variant="success">
          {{ page.props.flash.status }}
        </BaseAlert>
        <p class="text-sm text-slate-600 dark:text-slate-300">
          Enviaremos um link de redefinição para seu e-mail.
        </p>
        <BaseInput
          id="email"
          v-model="form.email"
          type="email"
          label="E-mail"
          required
          autocomplete="email"
          :error="form.errors.email"
        />
        <BaseButton type="submit" class="w-full" :loading="form.processing">
          Enviar link
        </BaseButton>
      </form>
    </BaseCard>
  </PublicLayout>
</template>
