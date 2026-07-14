<template>
  <div v-if="isSupported">
    <div class="grid gap-2">
      <Button type="button" variant="outline" class="w-full" @click="verify" :disabled="isLoading">
        <ButtonState
          :processing="isLoading"
          :processing-label="props.loadingLabel ?? 'Authenticating'"
        >
          <KeyRound aria-hidden="true" />
          {{ props.label ?? 'Sign in with a passkey' }}
        </ButtonState>
      </Button>

      <Alert v-if="error" variant="destructive">
        <TriangleAlertIcon aria-hidden="true" />
        <AlertTitle>Passkey authentication failed</AlertTitle>
        <AlertDescription>{{ error }}</AlertDescription>
      </Alert>
    </div>

    <div class="relative my-6">
      <div class="absolute inset-0 flex items-center">
        <Separator class="w-full" />
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">
          {{ props.separator ?? 'Or continue with email' }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { UrlMethodPair } from '@inertiajs/core'
import { router } from '@inertiajs/vue3'
import { usePasskeyVerify } from '@laravel/passkeys/vue'
import { KeyRound, TriangleAlertIcon } from '@lucide/vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import { Separator } from '@/Components/Base/Separator'

type Props = {
  routes?: {
    options: UrlMethodPair
    submit: UrlMethodPair
  }
  label?: string
  loadingLabel?: string
  separator?: string
}

const props = defineProps<Props>()

const { verify, isLoading, error, isSupported } = usePasskeyVerify({
  ...(props.routes
    ? {
        routes: {
          options: props.routes.options.url,
          submit: props.routes.submit.url,
        },
      }
    : {}),
  onSuccess: (response) => {
    router.visit(response.redirect ?? '/dashboard')
  },
})
</script>
