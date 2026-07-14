<template>
  <header class="space-y-1">
    <h2 :class="props.compact ? 'text-base font-medium' : 'text-xl font-semibold tracking-tight'">
      {{ title }}
    </h2>
    <p v-if="description" class="text-sm text-muted-foreground">
      {{ description }}
    </p>
  </header>
</template>

<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    title: string
    description?: string
    compact?: boolean
  }>(),
  {
    compact: false,
  },
)
</script>
