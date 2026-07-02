<template>
  <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
    <SidebarGroupContent>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in navigation" :key="item.title">
          <SidebarMenuButton
            class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
            :as="markRaw(NavigationButton)"
            :item="item"
            v-bind="externalLinkAttributes(item)"
          >
            <NavigationButtonIcon />
            <span>{{ item.title }}</span>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarGroupContent>
  </SidebarGroup>
</template>

<script setup lang="ts">
import {
  isLinkAction,
  NavigationButton,
  NavigationButtonIcon,
  type Menu,
  type NavigationItem,
  useNavigation,
} from '@stacktrace/ui'
import { computed, markRaw } from 'vue'
import {
  SidebarGroup,
  SidebarGroupContent,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/Components/Base/Sidebar'

type Props = {
  menu: Menu
  class?: string
}

const props = defineProps<Props>()
const navigation = useNavigation(computed(() => props.menu))

const externalLinkAttributes = (item: NavigationItem) =>
  item.action && isLinkAction(item.action) && item.action.external
    ? { target: '_blank', rel: 'noopener noreferrer' }
    : {}
</script>
