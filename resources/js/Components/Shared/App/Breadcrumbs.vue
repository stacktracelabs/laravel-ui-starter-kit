<template>
  <Breadcrumb>
    <BreadcrumbNavigation :list="breadcrumbs" />
  </Breadcrumb>
</template>

<script setup lang="ts">
import { Breadcrumb, BreadcrumbNavigation } from '@/Components/Base/Breadcrumb'
import type { Menu } from '@stacktrace/ui'

type Props = {
  breadcrumbs: Menu
}

defineProps<Props>()
</script>
