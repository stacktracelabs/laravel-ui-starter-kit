<template>
  <Head title="Forgot password" />

  <Alert v-if="status" variant="positive">
    <MailCheckIcon aria-hidden="true" />
    <AlertTitle>Reset link sent</AlertTitle>
    <AlertDescription>{{ status }}</AlertDescription>
  </Alert>

  <div class="space-y-6">
    <Form :action="route('password.email')" method="post" v-slot="{ errors, processing }">
      <FormControl for="email" label="Email address" :error="errors.email" required>
        <Input
          id="email"
          type="email"
          name="email"
          autocomplete="off"
          v-focus
          placeholder="email@example.com"
          required
          :aria-invalid="errors.email ? true : undefined"
        />
      </FormControl>

      <div class="my-6 flex items-center justify-start">
        <Button
          type="submit"
          class="w-full"
          :disabled="processing"
          data-test="email-password-reset-link-button"
        >
          <ButtonState :processing="processing">Email password reset link</ButtonState>
        </Button>
      </div>
    </Form>

    <div class="space-x-1 text-center text-sm text-muted-foreground">
      <span>Or, return to</span>
      <Link
        :href="route('login')"
        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
      >
        log in
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3'
import { MailCheckIcon } from '@lucide/vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'

defineOptions({
  layout: {
    title: 'Forgot password',
    description: 'Enter your email to receive a password reset link',
  },
})

defineProps<{
  status?: string
}>()
</script>
