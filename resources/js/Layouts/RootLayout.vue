<template>
  <slot />
  <ConfirmationDialog />
  <Toaster />
</template>

<script setup lang="ts">
import { ConfirmationDialog } from '@/Components/Base/ConfirmationDialog'
import { Toaster } from '@/Components/Base/Sonner'
</script>
