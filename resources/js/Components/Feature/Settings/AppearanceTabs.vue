<template>
  <ToggleGroup
    v-model="selectedAppearance"
    type="single"
    variant="outline"
    size="sm"
    aria-label="Color theme"
  >
    <ToggleGroupItem
      v-for="{ value, Icon, label } in tabs"
      :key="value"
      :value="value"
      :aria-label="`Use ${label.toLowerCase()} theme`"
    >
      <component :is="Icon" aria-hidden="true" />
      <span>{{ label }}</span>
    </ToggleGroupItem>
  </ToggleGroup>
</template>

<script setup lang="ts">
import { Monitor, Moon, Sun } from '@lucide/vue'
import { computed } from 'vue'
import { ToggleGroup, ToggleGroupItem } from '@/Components/Base/ToggleGroup'
import { useAppearance } from '@/Composables'
import type { Appearance } from '@/Types'

const { appearance, updateAppearance } = useAppearance()

const selectedAppearance = computed({
  get: () => appearance.value,
  set: (value: Appearance | undefined) => {
    if (value && value !== appearance.value) {
      updateAppearance(value)
    }
  },
})

const tabs = [
  { value: 'light', Icon: Sun, label: 'Light' },
  { value: 'dark', Icon: Moon, label: 'Dark' },
  { value: 'system', Icon: Monitor, label: 'System' },
] as const
</script>
