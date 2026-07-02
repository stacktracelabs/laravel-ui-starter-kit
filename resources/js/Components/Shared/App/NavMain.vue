<template>
  <SidebarNavigation :menu="menu" />
</template>

<script setup lang="ts">
import { SidebarNavigation } from '@/Components/Base/Sidebar'
import type { Menu } from '@stacktrace/ui'

defineProps<{
  menu: Menu
}>()
</script>
