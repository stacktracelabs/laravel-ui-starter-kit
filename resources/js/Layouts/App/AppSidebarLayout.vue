<template>
  <AppShell variant="sidebar">
    <AppSidebar />
    <AppContent variant="sidebar" class="overflow-x-hidden">
      <AppSidebarHeader />
      <slot />
    </AppContent>
  </AppShell>
</template>

<script setup lang="ts">
import { AppContent, AppShell, AppSidebar, AppSidebarHeader } from '@/Components/Shared/App'
</script>
