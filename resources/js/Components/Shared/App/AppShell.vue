<template>
  <div v-if="variant === 'header'" class="flex min-h-screen w-full flex-col">
    <slot />
  </div>
  <SidebarProvider v-else :default-open="isOpen">
    <slot />
  </SidebarProvider>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { SidebarProvider } from '@/Components/Base/Sidebar'
import type { AppVariant } from '@/Types'

type Props = {
  variant?: AppVariant
}

withDefaults(defineProps<Props>(), {
  variant: 'sidebar',
})

const isOpen = usePage().props.sidebarOpen
</script>
