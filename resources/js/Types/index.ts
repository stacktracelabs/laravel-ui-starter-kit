import type { Config } from 'ziggy-js'
import type { Menu } from '@stacktrace/ui'
import type { Auth } from './auth'

export * from './auth'
export * from './ui'

export type NavigationMenus = {
  sidebar: Menu
  top: Menu
  headerRight: Menu
  footer: Menu
  settings: Menu
  user: Menu
  breadcrumbs: Menu
}

export type SharedData = {
  name: string
  auth: Auth
  navigation: NavigationMenus
  sidebarOpen: boolean
  ziggy: Config & { location: string }
  [key: string]: unknown
}
