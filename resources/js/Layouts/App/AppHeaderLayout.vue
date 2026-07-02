<template>
  <AppShell variant="header">
    <AppHeader />
    <AppContent variant="header">
      <slot />
    </AppContent>
  </AppShell>
</template>

<script setup lang="ts">
import { AppContent } from '@/Components/Shared'
import { AppHeader } from '@/Components/Shared'
import { AppShell } from '@/Components/Shared'
</script>
