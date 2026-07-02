import '../css/app.css'

import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js'
import { initializeTheme } from '@/Composables'
import { AppLayout, AuthLayout, RootLayout, SettingsLayout } from '@/Layouts'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

void createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  layout: (name) => {
    switch (true) {
      case name === 'Welcome':
        return RootLayout
      case name.startsWith('Auth/'):
        return [RootLayout, AuthLayout]
      case name.startsWith('Settings/'):
        return [RootLayout, AppLayout, SettingsLayout]
      default:
        return [RootLayout, AppLayout]
    }
  },
  progress: {
    color: '#4B5563',
  },
  withApp: (app) => {
    app.use(ZiggyVue)
  },
})

// This will set light / dark mode on page load...
initializeTheme()
