<template>
  <Head title="Confirm password" />

  <!-- @chisel-passkeys -->
  <PasskeyVerify
    :routes="{
      options: {
        url: route('passkey.confirm-options'),
        method: 'get',
      },
      submit: {
        url: route('passkey.confirm'),
        method: 'post',
      },
    }"
    label="Confirm with passkey"
    loading-label="Confirming..."
    separator="Or confirm with password"
  />
  <!-- @end-chisel-passkeys -->

  <Form
    :action="route('password.confirm.store')"
    method="post"
    reset-on-success
    v-slot="{ errors, processing }"
  >
    <div class="space-y-6">
      <div class="grid gap-2">
        <Label htmlFor="password">Password</Label>
        <PasswordInput
          id="password"
          name="password"
          class="mt-1 block w-full"
          required
          autocomplete="current-password"
          autofocus
        />

        <FormMessage v-if="errors.password" :message="errors.password" />
      </div>

      <div class="flex items-center">
        <Button class="w-full" :disabled="processing" data-test="confirm-password-button">
          <Spinner v-if="processing" />
          Confirm password
        </Button>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { Button } from '@/Components/Base/Button'
import { FormMessage } from '@/Components/Base/Form'
import { Label } from '@/Components/Base/Label'
import { PasswordInput } from '@/Components/Base/PasswordInput'
import { Spinner } from '@/Components/Base/Spinner'
/* @chisel-passkeys */
import { PasskeyVerify } from '@/Components/Feature/Auth'
/* @end-chisel-passkeys */

defineOptions({
  layout: {
    title: 'Confirm password',
    description:
      'This is a secure area of the application. Please confirm your password before continuing.',
  },
})
</script>
