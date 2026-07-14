<template>
  <div>
    <div class="border-b border-sidebar-border/80">
      <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
        <!-- Mobile Menu -->
        <div class="lg:hidden">
          <Sheet>
            <SheetTrigger :as-child="true">
              <Button
                variant="ghost"
                size="icon"
                class="mr-2 h-9 w-9"
                aria-label="Open navigation menu"
              >
                <Menu class="h-5 w-5" />
              </Button>
            </SheetTrigger>
            <SheetContent side="left" class="w-[300px] p-6">
              <SheetTitle class="sr-only">Navigation menu</SheetTitle>
              <SheetHeader class="flex justify-start text-left">
                <Logo class="size-7" role="img" aria-label="StackTrace" />
              </SheetHeader>
              <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                <nav class="-mx-3 space-y-1">
                  <NavigationButton
                    v-for="item in topNavigation"
                    :key="item.title"
                    :item="item"
                    class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                    :class="item.isActive || item.isChildActive ? activeItemStyles : undefined"
                  >
                    <NavigationButtonIcon class="h-5 w-5" />
                    {{ item.title }}
                  </NavigationButton>
                </nav>
                <div class="flex flex-col space-y-4">
                  <NavigationButton
                    v-for="item in headerRightNavigation"
                    :key="item.title"
                    :item="item"
                    v-bind="externalLinkAttributes(item)"
                    class="flex items-center space-x-2 text-sm font-medium"
                  >
                    <NavigationButtonIcon class="h-5 w-5" />
                    <span>{{ item.title }}</span>
                  </NavigationButton>
                </div>
              </div>
            </SheetContent>
          </Sheet>
        </div>

        <Link :href="route('dashboard')" class="flex items-center gap-2 font-semibold">
          <Logo class="size-7" aria-hidden="true" />
          <span class="hidden sm:inline">{{ page.props.name }}</span>
        </Link>

        <!-- Desktop Menu -->
        <div class="hidden h-full lg:flex lg:flex-1">
          <nav aria-label="Main navigation" class="ml-10 flex h-full items-center gap-2">
            <Button
              v-for="item in topNavigation"
              :key="item.title"
              variant="ghost"
              class="relative h-full rounded-none px-3"
              :class="item.isActive || item.isChildActive ? activeItemStyles : undefined"
              as-child
            >
              <NavigationButton :item="item">
                <NavigationButtonIcon class="mr-2 h-4 w-4" />
                {{ item.title }}
                <span
                  v-if="item.isActive || item.isChildActive"
                  class="absolute bottom-0 left-0 h-0.5 w-full bg-black dark:bg-white"
                />
              </NavigationButton>
            </Button>
          </nav>
        </div>

        <div class="ml-auto flex items-center space-x-2">
          <div class="relative flex items-center gap-1">
            <div class="hidden gap-1 lg:flex">
              <Button
                v-for="item in headerRightNavigation"
                :key="item.title"
                variant="ghost"
                size="sm"
                as-child
              >
                <NavigationButton :item="item" v-bind="externalLinkAttributes(item)">
                  {{ item.title }}
                </NavigationButton>
              </Button>
            </div>
          </div>

          <DropdownMenu>
            <DropdownMenuTrigger :as-child="true">
              <Button
                variant="ghost"
                size="icon"
                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                :aria-label="`Open user menu for ${auth.user.name}`"
              >
                <Avatar class="size-8 overflow-hidden rounded-full">
                  <AvatarFallback
                    class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                  >
                    {{ getInitials(auth.user.name) }}
                  </AvatarFallback>
                </Avatar>
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" class="w-56">
              <UserMenuContent :user="auth.user" />
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </div>
    </div>

    <div v-if="breadcrumbs.length > 1" class="flex w-full border-b border-sidebar-border/70">
      <div
        class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl"
      >
        <Breadcrumbs :breadcrumbs="breadcrumbs" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { Menu } from '@lucide/vue'
import {
  isLinkAction,
  NavigationButton,
  NavigationButtonIcon,
  type NavigationItem,
  useNavigation,
} from '@stacktrace/ui'
import { computed } from 'vue'
import { Logo } from '@/Components/Base/Logo'
import { Breadcrumbs } from '@/Components/Shared/App'
import { Avatar, AvatarFallback } from '@/Components/Base/Avatar'
import { Button } from '@/Components/Base/Button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/Components/Base/DropdownMenu'
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/Base/Sheet'
import { UserMenuContent } from '@/Components/Shared/App'
import { getInitials } from '@/Composables'

const page = usePage()
const auth = computed(() => ({ user: page.props.auth.user! }))
const topNavigation = useNavigation(computed(() => page.props.navigation.top))
const headerRightNavigation = useNavigation(computed(() => page.props.navigation.headerRight))
const breadcrumbs = computed(() => page.props.navigation.breadcrumbs)

const activeItemStyles = 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100'

const externalLinkAttributes = (item: NavigationItem) =>
  item.action && isLinkAction(item.action) && item.action.external
    ? { target: '_blank', rel: 'noopener noreferrer' }
    : {}
</script>
