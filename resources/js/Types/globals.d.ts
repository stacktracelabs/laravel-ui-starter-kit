import type { createHeadManager, Page, Router } from '@inertiajs/core'
import type { SharedData } from '@/Types'

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
  interface ImportMetaEnv {
    readonly VITE_APP_NAME: string

    [key: string]: string | boolean | undefined
  }

  interface ImportMeta {
    readonly env: ImportMetaEnv
    readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>
  }
}

declare module '@inertiajs/core' {
  export interface InertiaConfig {
    sharedPageProps: SharedData
    flashDataType: {
      toast?: {
        title: string
        content: string | null
        variant: 'default' | 'destructive'
      }
    }
  }
}

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $inertia: Router
    $page: Page
    $headManager: ReturnType<typeof createHeadManager>
  }
}
