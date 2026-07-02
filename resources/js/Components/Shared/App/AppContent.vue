<template>
  <SidebarInset v-if="props.variant === 'sidebar'" :class="className">
    <slot />
  </SidebarInset>
  <main
    v-else
    class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl"
    :class="className"
  >
    <slot />
  </main>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { SidebarInset } from '@/Components/Base/Sidebar'
import type { AppVariant } from '@/Types'

type Props = {
  variant?: AppVariant
  class?: string
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'sidebar',
})
const className = computed(() => props.class)
</script>
