<template>
  <Head title="Forgot password" />

  <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
    {{ status }}
  </div>

  <div class="space-y-6">
    <Form :action="route('password.email')" method="post" v-slot="{ errors, processing }">
      <div class="grid gap-2">
        <Label for="email">Email address</Label>
        <Input
          id="email"
          type="email"
          name="email"
          autocomplete="off"
          autofocus
          placeholder="email@example.com"
        />
        <FormMessage v-if="errors.email" :message="errors.email" />
      </div>

      <div class="my-6 flex items-center justify-start">
        <Button
          class="w-full"
          :processing="processing"
          :disabled="processing"
          data-test="email-password-reset-link-button"
        >
          Email password reset link
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
import { Button } from '@/Components/Base/Button'
import { FormMessage } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import { Label } from '@/Components/Base/Label'

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
