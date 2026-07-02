<template>
  <AuthLayout :title="title" :description="description">
    <slot />
  </AuthLayout>
</template>

<script setup lang="ts">
import { AuthSimpleLayout as AuthLayout } from './Auth'

const { title = '', description = '' } = defineProps<{
  title?: string
  description?: string
}>()
</script>
