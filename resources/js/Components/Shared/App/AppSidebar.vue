<template>
  <Sidebar collapsible="offcanvas" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('dashboard')">
              <span
                class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground"
              >
                <Logo class="size-5" aria-hidden="true" />
              </span>
              <span class="grid flex-1 text-left text-sm leading-tight">
                <span class="truncate font-semibold">{{ page.props.name }}</span>
                <span class="truncate text-xs text-sidebar-foreground/70">StackTrace UI</span>
              </span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :menu="navigation.sidebar" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :menu="navigation.footer" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { Logo } from '@/Components/Base/Logo'
import { NavFooter } from '@/Components/Shared/App'
import { NavMain } from '@/Components/Shared/App'
import { NavUser } from '@/Components/Shared/App'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/Components/Base/Sidebar'

const page = usePage()
const navigation = computed(() => page.props.navigation)
</script>
