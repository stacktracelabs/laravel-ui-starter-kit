import '../css/app.css'
import { initializeTheme } from './Composables/useAppearance'

import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js'

void createInertiaApp({
  withApp: app => {
    app.use(ZiggyVue)
  }
})

// This will set light / dark mode on page load...
initializeTheme()
