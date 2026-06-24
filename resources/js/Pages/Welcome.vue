<template>
    <p>{{ message }}</p>
</template>

<script setup lang="ts">
defineProps<{
  message: string
}>()
</script>
