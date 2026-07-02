<script setup lang="ts">
import type { SeoData } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{ seo: SeoData }>();
</script>

<template>
  <Head :title="seo.title">
    <meta
      v-if="seo.description"
      head-key="description"
      name="description"
      :content="seo.description"
    />
    <meta head-key="robots" name="robots" :content="seo.robots" />
    <link v-if="seo.canonical" head-key="canonical" rel="canonical" :href="seo.canonical" />
    <meta head-key="og:title" property="og:title" :content="seo.title" />
    <meta
      v-if="seo.description"
      head-key="og:description"
      property="og:description"
      :content="seo.description"
    />
    <meta head-key="og:type" property="og:type" :content="seo.type" />
    <meta v-if="seo.image" head-key="og:image" property="og:image" :content="seo.image" />
    <meta head-key="twitter:card" name="twitter:card" :content="seo.twitterCard" />
  </Head>
</template>
