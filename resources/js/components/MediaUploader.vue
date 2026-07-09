<script setup lang="ts">
import type { MediaAsset } from '@/types';
import axios from 'axios';
import { ref } from 'vue';

const emit = defineEmits<{ uploaded: [asset: MediaAsset] }>();
const file = ref<File | null>(null);
const altText = ref('');
const error = ref<string | null>(null);
const loading = ref(false);

const selectFile = (event: Event): void => {
  file.value = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const upload = async (): Promise<void> => {
  if (!file.value) return;
  loading.value = true;
  error.value = null;

  const body = new FormData();
  body.append('file', file.value);
  body.append('alt_text', altText.value);

  try {
    const response = await axios.post<{ data: MediaAsset }>('/media', body);
    emit('uploaded', response.data.data);
    file.value = null;
    altText.value = '';
  } catch {
    error.value = 'Não foi possível enviar o arquivo.';
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <form
    class="space-y-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900"
    @submit.prevent="upload"
  >
    <div>
      <label for="media-file" class="mb-1 block text-sm font-medium">Imagem ou PDF</label>
      <input
        id="media-file"
        type="file"
        accept="image/jpeg,image/png,image/webp,application/pdf"
        required
        @change="selectFile"
      />
    </div>
    <div>
      <label for="media-alt" class="mb-1 block text-sm font-medium">Texto alternativo</label>
      <input
        id="media-alt"
        v-model="altText"
        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
        maxlength="255"
      />
    </div>
    <p v-if="error" class="text-sm text-red-700 dark:text-red-300">{{ error }}</p>
    <button
      class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-400"
      :disabled="loading || !file"
    >
      {{ loading ? 'Enviando...' : 'Enviar arquivo' }}
    </button>
  </form>
</template>
