<script setup lang="ts">
import { useTheme } from '@/composables/useTheme';
import { Moon, Sun } from 'lucide-vue-next';

const { isDark, toggleTheme } = useTheme();
</script>

<template>
  <button
    type="button"
    class="inline-flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-blue-300 hover:text-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-blue-500 dark:hover:text-blue-300 dark:focus:ring-offset-slate-950"
    :aria-label="isDark ? 'Ativar tema claro' : 'Ativar tema escuro'"
    :title="isDark ? 'Ativar tema claro' : 'Ativar tema escuro'"
    @click="toggleTheme"
  >
    <Sun v-if="isDark" class="size-4" aria-hidden="true" />
    <Moon v-else class="size-4" aria-hidden="true" />
  </button>
</template>
