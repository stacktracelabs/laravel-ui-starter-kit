<template>
  <div class="flex flex-col gap-6 px-4 py-6 lg:gap-8">
    <SectionHeading title="Settings" description="Manage your profile and account settings" />

    <div class="flex flex-col gap-4 lg:flex-row lg:gap-12">
      <aside class="w-full max-w-xl lg:w-48">
        <nav class="flex flex-col space-y-1 space-x-0" aria-label="Settings">
          <Button
            v-for="item in navigation"
            :key="item.title"
            variant="ghost"
            :class="['w-full justify-start', { 'bg-muted': item.isActive || item.isChildActive }]"
            as-child
          >
            <NavigationButton :item="item" class="w-full justify-start">
              {{ item.title }}
            </NavigationButton>
          </Button>
        </nav>
      </aside>

      <Separator class="lg:hidden" />

      <div class="flex-1 md:max-w-2xl">
        <section class="max-w-xl space-y-12">
          <slot />
        </section>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { NavigationButton, useNavigation } from '@stacktrace/ui'
import { computed } from 'vue'
import { Button } from '@/Components/Base/Button'
import { Separator } from '@/Components/Base/Separator'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'

const page = usePage()
const navigation = useNavigation(computed(() => page.props.navigation.settings))
</script>
