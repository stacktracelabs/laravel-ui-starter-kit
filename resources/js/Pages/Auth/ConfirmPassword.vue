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
      <FormControl for="password" label="Password" :error="errors.password" required>
        <PasswordInput
          id="password"
          name="password"
          class="mt-1 w-full"
          required
          autocomplete="current-password"
          autofocus
          :aria-invalid="errors.password ? true : undefined"
        />
      </FormControl>

      <div class="flex items-center">
        <Button
          type="submit"
          class="w-full"
          :disabled="processing"
          data-test="confirm-password-button"
        >
          <ButtonState :processing="processing">Confirm password</ButtonState>
        </Button>
      </div>
    </div>
  </Form>
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { Button, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import PasswordInput from '@/Components/Shared/PasswordInput.vue'
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
