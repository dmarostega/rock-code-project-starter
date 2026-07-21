<script setup lang="ts">
defineProps<{
  title: string;
  description?: string;
}>();
</script>

<template>
  <section
    class="rounded-xl border border-dashed border-slate-300 p-8 text-center dark:border-slate-700"
  >
    <h2 class="text-lg font-semibold">{{ title }}</h2>
    <p v-if="description" class="mt-2 text-sm text-slate-600 dark:text-slate-300">
      {{ description }}
    </p>
    <div v-if="$slots.action" class="mt-5"><slot name="action" /></div>
  </section>
</template>
