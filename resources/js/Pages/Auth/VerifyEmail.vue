<template>
  <Head title="Email verification" />

  <Alert v-if="status === 'verification-link-sent'" variant="positive">
    <MailCheckIcon aria-hidden="true" />
    <AlertTitle>Verification link sent</AlertTitle>
    <AlertDescription>
      A new verification link has been sent to the email address associated with your account.
    </AlertDescription>
  </Alert>

  <Form
    :action="route('verification.send')"
    method="post"
    class="space-y-6 text-center"
    v-slot="{ processing }"
  >
    <Button type="submit" :disabled="processing" variant="secondary">
      <ButtonState :processing="processing">Resend verification email</ButtonState>
    </Button>

    <Link
      :href="route('logout')"
      method="post"
      as="button"
      class="mx-auto block text-sm text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
    >
      Log out
    </Link>
  </Form>
</template>

<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3'
import { MailCheckIcon } from '@lucide/vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'

defineOptions({
  layout: {
    title: 'Email verification',
    description: 'Please verify your email address by clicking on the link we just emailed to you.',
  },
})

defineProps<{
  status?: string
}>()
</script>
