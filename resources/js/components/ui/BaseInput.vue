<script setup lang="ts">
withDefaults(
  defineProps<{
    id: string;
    label: string;
    error?: string;
    type?: string;
    required?: boolean;
    autocomplete?: string;
    maxlength?: number;
  }>(),
  {
    error: '',
    type: 'text',
    required: false,
    autocomplete: undefined,
    maxlength: undefined,
  },
);

const model = defineModel<string>({ required: true });
</script>

<template>
  <div>
    <label class="mb-1 block text-sm" :for="id">{{ label }}</label>
    <input
      :id="id"
      v-model="model"
      :type="type"
      :required="required"
      :autocomplete="autocomplete"
      :maxlength="maxlength"
      :aria-invalid="Boolean(error)"
      :aria-describedby="error ? `${id}-error` : undefined"
      class="w-full rounded-lg border bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-slate-950 dark:text-slate-100"
      :class="
        error ? 'border-red-500 dark:border-red-400' : 'border-slate-300 dark:border-slate-700'
      "
    />
    <p v-if="error" :id="`${id}-error`" class="mt-1 text-sm text-red-700 dark:text-red-300">
      {{ error }}
    </p>
  </div>
</template>
