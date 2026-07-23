<script setup lang="ts">
withDefaults(
  defineProps<{
    label?: string;
  }>(),
  {
    label: 'Carregando...',
  },
);
</script>

<template>
  <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300" role="status">
    <span
      class="size-5 animate-spin rounded-full border-2 border-blue-600 border-r-transparent dark:border-blue-400"
      aria-hidden="true"
    />
    <span>{{ label }}</span>
  </div>
</template>
