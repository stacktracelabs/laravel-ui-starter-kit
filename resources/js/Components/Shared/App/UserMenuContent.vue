<template>
  <DropdownMenuLabel class="p-0 font-normal">
    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
      <UserInfo :user="user" :show-email="true" />
    </div>
  </DropdownMenuLabel>
  <DropdownMenuSeparator />
  <DropdownMenuGroup>
    <DropdownMenuItem v-for="item in navigation" :key="item.title" :as-child="true">
      <NavigationButton :item="item" class="block w-full cursor-pointer" prefetch>
        <NavigationButtonIcon class="mr-2 h-4 w-4" />
        {{ item.title }}
      </NavigationButton>
    </DropdownMenuItem>
  </DropdownMenuGroup>
  <DropdownMenuSeparator />
  <DropdownMenuItem :as-child="true">
    <Link
      class="block w-full cursor-pointer"
      :href="route('logout')"
      method="post"
      @click="handleLogout"
      as="button"
      data-test="logout-button"
    >
      <LogOut class="mr-2 h-4 w-4" />
      Log out
    </Link>
  </DropdownMenuItem>
</template>

<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3'
import { LogOut } from '@lucide/vue'
import { NavigationButton, NavigationButtonIcon, useNavigation } from '@stacktrace/ui'
import { computed } from 'vue'
import {
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
} from '@/Components/Base/DropdownMenu'
import { UserInfo } from '@/Components/Shared/App'
import type { User } from '@/Types'

type Props = {
  user: User
}

const page = usePage()
const navigation = useNavigation(computed(() => page.props.navigation.user))

const handleLogout = () => {
  router.flushAll()
}

defineProps<Props>()
</script>
