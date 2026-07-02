<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('dashboard')">
              <Logo />
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
import { route } from 'ziggy-js'

const page = usePage()
const navigation = computed(() => page.props.navigation)
</script>
