import { defineConfig, lazyPlugins } from 'vite-plus'
import laravel from 'laravel-vite-plugin'
import { bunny } from 'laravel-vite-plugin/fonts'
import tailwindcss from '@tailwindcss/vite'
import inertia from '@inertiajs/vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: lazyPlugins(() => [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: true,
      fonts: [
        bunny('Instrument Sans', {
          weights: [400, 500, 600],
        }),
      ],
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    tailwindcss(),
    inertia(),
  ]),
  server: {
    watch: {
      ignored: [
        '**/storage/framework/views/**',
        '**/vendor/**',
        '**/.agents/**',
        '**/.ai/**',
        '**/.claude/**',
        '**/.codex/**',
        '**/.cursor/**',
        '**/.junie/**',
      ],
    },
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
      '@stacktrace/ui': fileURLToPath(new URL('./vendor/stacktrace/ui', import.meta.url)),
    },
  },
  lint: {
    plugins: ['eslint', 'typescript', 'unicorn', 'oxc', 'vue'],
    env: { browser: true },
    categories: { correctness: 'error' },
    ignorePatterns: [
      'vendor/**',
      'node_modules/**',
      'public/**',
      'bootstrap/ssr/**',
      'resources/js/Components/Base/**',
    ],
    options: {
      denyWarnings: true,
      typeAware: true,
    },
  },
  fmt: {
    printWidth: 100,
    tabWidth: 2,
    singleQuote: true,
    semi: false,
    sortImports: false,
    ignorePatterns: [
      '**/*.md',
      '**/*.json',
      '.github/**',
      '.agents/**',
      '.ai/**',
      'resources/js/Components/Base/**',
    ],
  },
})
