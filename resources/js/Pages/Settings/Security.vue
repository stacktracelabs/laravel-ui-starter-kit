<template>
  <Head title="Security settings" />

  <h1 class="sr-only">Security settings</h1>

  <div class="space-y-6">
    <Heading
      variant="small"
      title="Update password"
      description="Ensure your account is using a long, random password to stay secure"
    />

    <Form
      :action="route('user-password.update')"
      method="put"
      :options="{
        preserveScroll: true,
      }"
      reset-on-success
      :reset-on-error="['password', 'password_confirmation', 'current_password']"
      class="space-y-6"
      v-slot="{ errors, processing }"
    >
      <div class="grid gap-2">
        <Label for="current_password">Current password</Label>
        <PasswordInput
          id="current_password"
          name="current_password"
          class="mt-1 block w-full"
          autocomplete="current-password"
          placeholder="Current password"
        />
        <FormMessage v-if="errors.current_password" :message="errors.current_password" />
      </div>

      <div class="grid gap-2">
        <Label for="password">New password</Label>
        <PasswordInput
          id="password"
          name="password"
          class="mt-1 block w-full"
          autocomplete="new-password"
          placeholder="New password"
          :passwordrules="props.passwordRules"
        />
        <FormMessage v-if="errors.password" :message="errors.password" />
      </div>

      <div class="grid gap-2">
        <Label for="password_confirmation">Confirm password</Label>
        <PasswordInput
          id="password_confirmation"
          name="password_confirmation"
          class="mt-1 block w-full"
          autocomplete="new-password"
          placeholder="Confirm password"
          :passwordrules="props.passwordRules"
        />
        <FormMessage v-if="errors.password_confirmation" :message="errors.password_confirmation" />
      </div>

      <div class="flex items-center gap-4">
        <Button
          :processing="processing"
          :disabled="processing"
          data-test="update-password-button"
        >
          Save
        </Button>
      </div>
    </Form>
  </div>

  <!-- @chisel-2fa -->
  <ManageTwoFactor
    :canManageTwoFactor="canManageTwoFactor"
    :requiresConfirmation="requiresConfirmation"
    :twoFactorEnabled="twoFactorEnabled"
  />
  <!-- @end-chisel-2fa -->

  <!-- @chisel-passkeys -->
  <ManagePasskeys :canManagePasskeys="canManagePasskeys" :passkeys="passkeys" />
  <!-- @end-chisel-passkeys -->
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { Button } from '@/Components/Base/Button'
import { FormMessage } from '@/Components/Base/Form'
import { Heading } from '@/Components/Base/Heading'
import { Label } from '@/Components/Base/Label'
import { PasswordInput } from '@/Components/Base/PasswordInput'
/* @chisel-passkeys */
import type { ManagePasskeysProps } from '@/Components/Feature/Passkeys'
import { ManagePasskeys } from '@/Components/Feature/Passkeys'
/* @end-chisel-passkeys */
/* @chisel-2fa */
import type { ManageTwoFactorProps } from '@/Components/Feature/TwoFactor'
import { ManageTwoFactor } from '@/Components/Feature/TwoFactor'
/* @end-chisel-2fa */

type Props = {
  passwordRules: string
} /* @chisel-passkeys */ & ManagePasskeysProps /* @end-chisel-passkeys */ /* @chisel-2fa */ &
  ManageTwoFactorProps /* @end-chisel-2fa */

const props = defineProps<Props>()
</script>
