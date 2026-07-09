<script setup lang="ts">
import MediaUploader from '@/components/MediaUploader.vue';
import SeoHead from '@/components/SeoHead.vue';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import type { MediaAsset, SeoData } from '@/types';
import { ref } from 'vue';

defineProps<{ seo: SeoData }>();
const uploaded = ref<MediaAsset[]>([]);
</script>

<template>
  <SeoHead :seo="seo" />
  <AuthenticatedLayout>
    <div class="grid gap-8 lg:grid-cols-2">
      <section>
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="mt-2 text-slate-600">Substitua esta tela pelo primeiro fluxo real do produto.</p>
      </section>
      <section>
        <h2 class="mb-3 text-lg font-semibold">Exemplo do módulo de mídia</h2>
        <MediaUploader @uploaded="uploaded.unshift($event)" />
        <ul class="mt-4 space-y-2 text-sm">
          <li v-for="asset in uploaded" :key="asset.id">
            <a class="text-blue-700 underline" :href="asset.url" target="_blank">{{
              asset.display_name
            }}</a>
          </li>
        </ul>
      </section>
    </div>
  </AuthenticatedLayout>
</template>
