<script setup lang="ts">
type ButtonVariant = 'primary' | 'secondary' | 'danger' | 'ghost';

withDefaults(
  defineProps<{
    type?: 'button' | 'submit' | 'reset';
    variant?: ButtonVariant;
    loading?: boolean;
    disabled?: boolean;
  }>(),
  {
    type: 'button',
    variant: 'primary',
    loading: false,
    disabled: false,
  },
);
</script>

<template>
  <button
    :type="type"
    :disabled="loading || disabled"
    :aria-busy="loading"
    class="inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 font-semibold transition-colors disabled:cursor-not-allowed disabled:opacity-50"
    :class="{
      'bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400':
        variant === 'primary',
      'border border-slate-300 bg-white text-slate-900 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800':
        variant === 'secondary',
      'bg-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400':
        variant === 'danger',
      'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800':
        variant === 'ghost',
    }"
  >
    <span
      v-if="loading"
      class="size-4 animate-spin rounded-full border-2 border-current border-r-transparent"
      aria-hidden="true"
    />
    <slot />
  </button>
</template>
