import '../css/app.css'
import { initializeTheme } from './Composables/useAppearance'

import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js'
import AppLayout from '@/Layouts/AppLayout.vue'
import AuthLayout from '@/Layouts/AuthLayout.vue'
import SettingsLayout from '@/Layouts/Settings/Layout.vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

void createInertiaApp({
  title: title => (title ? `${title} - ${appName}` : appName),
  layout: name => {
    switch (true) {
      case name === 'Welcome':
        return null
      case name.startsWith('Auth/'):
        return AuthLayout
      case name.startsWith('Settings/'):
        return [AppLayout, SettingsLayout]
      default:
        return AppLayout
    }
  },
  progress: {
    color: '#4B5563',
  },
  withApp: app => {
    app.use(ZiggyVue)
  }
})

// This will set light / dark mode on page load...
initializeTheme()
