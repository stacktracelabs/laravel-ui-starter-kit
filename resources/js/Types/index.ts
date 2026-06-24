import type { Config } from 'ziggy-js'

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  ziggy: Config & { location: string }
}
