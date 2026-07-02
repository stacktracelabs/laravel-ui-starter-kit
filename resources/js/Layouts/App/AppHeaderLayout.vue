<template>
  <AppShell variant="header">
    <AppHeader />
    <AppContent variant="header">
      <slot />
    </AppContent>
  </AppShell>
</template>

<script setup lang="ts">
import { AppContent, AppHeader, AppShell } from '@/Components/Shared/App'
</script>
