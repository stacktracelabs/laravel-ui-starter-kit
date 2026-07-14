<template>
  <Head title="Appearance settings" />

  <h1 class="sr-only">Appearance settings</h1>

  <div class="space-y-6">
    <SectionHeading
      compact
      title="Appearance settings"
      description="Update the appearance settings for your account"
    />
    <AppearanceTabs />
  </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { AppearanceTabs } from '@/Components/Feature/Settings'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'
</script>
