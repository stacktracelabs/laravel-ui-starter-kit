<template>
  <Head title="Email verification" />

  <div
    v-if="status === 'verification-link-sent'"
    class="mb-4 text-center text-sm font-medium text-green-600"
  >
    A new verification link has been sent to the email address associated with your account.
  </div>

  <Form
    :action="route('verification.send')"
    method="post"
    class="space-y-6 text-center"
    v-slot="{ processing }"
  >
    <Button :processing="processing" :disabled="processing" variant="secondary">
      Resend verification email
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
import { Button } from '@/Components/Base/Button'

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
