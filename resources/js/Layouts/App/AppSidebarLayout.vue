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
import { AppContent } from '@/Components/Shared'
import { AppShell } from '@/Components/Shared'
import { AppSidebar } from '@/Components/Shared'
import { AppSidebarHeader } from '@/Components/Shared'
</script>
