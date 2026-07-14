import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import inertia from '@inertiajs/vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: true,
      fonts: [
        bunny('Instrument Sans', {
          weights: [400, 500, 600],
        }),
      ],
    }),
    vue(),
    tailwindcss(),
    inertia(),
  ],
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
      '@stacktrace/ui': fileURLToPath(new URL('./vendor/stacktrace/ui', import.meta.url)),
    },
  },
  build: {
    rolldownOptions: {
      // TODO: Remove when updating vueuse beyond v14.3.0
      onLog(level, log, defaultHandler) {
        if (log.code === 'INVALID_ANNOTATION') {
          return
        }

        defaultHandler(level, log)
      },
    },
  },
})
