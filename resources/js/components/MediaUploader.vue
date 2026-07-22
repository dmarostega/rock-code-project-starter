<script setup lang="ts">
import BaseButton from '@/components/ui/BaseButton.vue';
import BaseCard from '@/components/ui/BaseCard.vue';
import BaseInput from '@/components/ui/BaseInput.vue';
import type { MediaAsset } from '@/types';
import axios from 'axios';
import { ref } from 'vue';

type UploadErrorResponse = {
  message?: string;
  errors?: {
    file?: string[];
  };
};

const emit = defineEmits<{ uploaded: [asset: MediaAsset] }>();
const file = ref<File | null>(null);
const altText = ref('');
const error = ref<string | null>(null);
const loading = ref(false);

const selectFile = (event: Event): void => {
  file.value = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const uploadErrorMessage = (exception: unknown): string => {
  const fallback = 'N\u00e3o foi poss\u00edvel enviar o arquivo.';

  if (!axios.isAxiosError<UploadErrorResponse>(exception)) {
    return fallback;
  }

  return exception.response?.data.errors?.file?.[0] ?? exception.response?.data.message ?? fallback;
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
  } catch (exception) {
    error.value = uploadErrorMessage(exception);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <BaseCard class="p-5">
    <form class="space-y-4" @submit.prevent="upload">
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
      <BaseInput id="media-alt" v-model="altText" label="Texto alternativo" :maxlength="255" />
      <p v-if="error" class="text-sm text-red-700 dark:text-red-300" role="alert">{{ error }}</p>
      <BaseButton type="submit" :loading="loading" :disabled="!file"> Enviar arquivo </BaseButton>
    </form>
  </BaseCard>
</template>
