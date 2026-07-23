<script setup lang="ts">
import MediaUploader from '@/components/MediaUploader.vue';
import SeoHead from '@/components/SeoHead.vue';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import type { MediaAsset, PageProps, SeoData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{ seo: SeoData }>();
const page = usePage<PageProps>();
const uploaded = ref<MediaAsset[]>([]);
</script>

<template>
  <SeoHead :seo="seo" />
  <AuthenticatedLayout>
    <div class="grid gap-8 lg:grid-cols-2">
      <section>
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="mt-2 text-slate-600 dark:text-slate-300">
          Substitua esta tela pelo primeiro fluxo real do produto.
        </p>
      </section>
      <section>
        <h2 class="mb-3 text-lg font-semibold">Exemplo do módulo de mídia</h2>
        <MediaUploader
          v-if="page.props.appSettings.flags.media_uploads"
          @uploaded="uploaded.unshift($event)"
        />
        <p
          v-else
          class="rounded-lg border border-slate-200 p-4 text-sm text-slate-600 dark:border-slate-800 dark:text-slate-300"
        >
          O envio de mídia está desabilitado neste ambiente.
        </p>
        <ul v-if="page.props.appSettings.flags.media_uploads" class="mt-4 space-y-2 text-sm">
          <li v-for="asset in uploaded" :key="asset.id">
            <a
              class="text-blue-700 underline hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200"
              :href="asset.url"
              target="_blank"
              rel="noopener noreferrer"
              >{{ asset.display_name }}</a
            >
          </li>
        </ul>
      </section>
    </div>
  </AuthenticatedLayout>
</template>
