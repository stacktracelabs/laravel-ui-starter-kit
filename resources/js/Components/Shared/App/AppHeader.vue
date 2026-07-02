<template>
  <div>
    <div class="border-b border-sidebar-border/80">
      <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
        <!-- Mobile Menu -->
        <div class="lg:hidden">
          <Sheet>
            <SheetTrigger :as-child="true">
              <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                <Menu class="h-5 w-5" />
              </Button>
            </SheetTrigger>
            <SheetContent side="left" class="w-[300px] p-6">
              <SheetTitle class="sr-only">Navigation menu</SheetTitle>
              <SheetHeader class="flex justify-start text-left">
                <LogoIcon class="size-6 fill-current text-black dark:text-white" />
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

        <Link :href="route('dashboard')" class="flex items-center gap-x-2">
          <Logo />
        </Link>

        <!-- Desktop Menu -->
        <div class="hidden h-full lg:flex lg:flex-1">
          <NavigationMenu class="ml-10 flex h-full items-stretch">
            <NavigationMenuList class="flex h-full items-stretch space-x-2">
              <NavigationMenuItem
                v-for="item in topNavigation"
                :key="item.title"
                class="relative flex h-full items-center"
              >
                <NavigationButton
                  :item="item"
                  :class="[
                    navigationMenuTriggerStyle(),
                    item.isActive || item.isChildActive ? activeItemStyles : undefined,
                    'h-9 cursor-pointer px-3',
                  ]"
                >
                  <NavigationButtonIcon class="mr-2 h-4 w-4" />
                  {{ item.title }}
                </NavigationButton>
                <div
                  v-if="item.isActive || item.isChildActive"
                  class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                ></div>
              </NavigationMenuItem>
            </NavigationMenuList>
          </NavigationMenu>
        </div>

        <div class="ml-auto flex items-center space-x-2">
          <div class="relative flex items-center space-x-1">
            <Button variant="ghost" size="icon" class="group h-9 w-9 cursor-pointer">
              <Search class="size-5 opacity-80 group-hover:opacity-100" />
            </Button>

            <div class="hidden space-x-1 lg:flex">
              <template v-for="item in headerRightNavigation" :key="item.title">
                <TooltipProvider :delay-duration="0">
                  <Tooltip>
                    <TooltipTrigger>
                      <Button
                        variant="ghost"
                        size="icon"
                        as-child
                        plain
                        class="group h-9 w-9 cursor-pointer"
                      >
                        <NavigationButton :item="item" v-bind="externalLinkAttributes(item)">
                          <span class="sr-only">{{ item.title }}</span>
                          <NavigationButtonIcon class="size-5 opacity-80 group-hover:opacity-100" />
                        </NavigationButton>
                      </Button>
                    </TooltipTrigger>
                    <TooltipContent>
                      <p>{{ item.title }}</p>
                    </TooltipContent>
                  </Tooltip>
                </TooltipProvider>
              </template>
            </div>
          </div>

          <DropdownMenu>
            <DropdownMenuTrigger :as-child="true">
              <Button
                variant="ghost"
                size="icon"
                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
              >
                <Avatar class="size-8 overflow-hidden rounded-full">
                  <AvatarImage
                    v-if="auth.user.avatar"
                    :src="auth.user.avatar"
                    :alt="auth.user.name"
                  />
                  <AvatarFallback
                    class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                  >
                    {{ getInitials(auth.user?.name) }}
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
import { Menu, Search } from '@lucide/vue'
import {
  isLinkAction,
  NavigationButton,
  NavigationButtonIcon,
  type NavigationItem,
  useNavigation,
} from '@stacktrace/ui'
import { computed } from 'vue'
import { Logo, LogoIcon } from '@/Components/Base/Logo'
import { Breadcrumbs } from '@/Components/Shared/App'
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/Base/Avatar'
import { Button } from '@/Components/Base/Button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/Components/Base/DropdownMenu'
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuList,
  navigationMenuTriggerStyle,
} from '@/Components/Base/NavigationMenu'
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/Components/Base/Sheet'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/Components/Base/Tooltip'
import { UserMenuContent } from '@/Components/Shared/App'
import { getInitials } from '@/Composables'

const page = usePage()
const auth = computed(() => page.props.auth)
const topNavigation = useNavigation(computed(() => page.props.navigation.top))
const headerRightNavigation = useNavigation(computed(() => page.props.navigation.headerRight))
const breadcrumbs = computed(() => page.props.navigation.breadcrumbs)

const activeItemStyles = 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100'

const externalLinkAttributes = (item: NavigationItem) =>
  item.action && isLinkAction(item.action) && item.action.external
    ? { target: '_blank', rel: 'noopener noreferrer' }
    : {}
</script>
