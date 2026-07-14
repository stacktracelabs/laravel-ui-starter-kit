<template>
  <Breadcrumb>
    <BreadcrumbNavigation :list="breadcrumbs" />
  </Breadcrumb>
</template>

<script setup lang="ts">
import type { Menu } from '@stacktrace/ui'
import { Breadcrumb, BreadcrumbNavigation } from '@/Components/Base/Breadcrumb'

type Props = {
  breadcrumbs: Menu
}

defineProps<Props>()
</script>
