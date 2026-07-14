<template>
  <Head title="Security settings" />

  <h1 class="sr-only">Security settings</h1>

  <div class="space-y-6">
    <SectionHeading
      compact
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
      <FormControl for="current_password" label="Current password" :error="errors.current_password">
        <PasswordInput
          id="current_password"
          name="current_password"
          class="mt-1 w-full"
          autocomplete="current-password"
          placeholder="Current password"
          :aria-invalid="errors.current_password ? true : undefined"
        />
      </FormControl>

      <FormControl for="password" label="New password" :error="errors.password">
        <PasswordInput
          id="password"
          name="password"
          class="mt-1 w-full"
          autocomplete="new-password"
          placeholder="New password"
          :passwordrules="props.passwordRules"
          :aria-invalid="errors.password ? true : undefined"
        />
      </FormControl>

      <FormControl
        for="password_confirmation"
        label="Confirm password"
        :error="errors.password_confirmation"
      >
        <PasswordInput
          id="password_confirmation"
          name="password_confirmation"
          class="mt-1 w-full"
          autocomplete="new-password"
          placeholder="Confirm password"
          :passwordrules="props.passwordRules"
          :aria-invalid="errors.password_confirmation ? true : undefined"
        />
      </FormControl>

      <div class="flex items-center gap-4">
        <Button type="submit" :disabled="processing" data-test="update-password-button">
          <ButtonState :processing="processing">Save</ButtonState>
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
import { Button, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import PasswordInput from '@/Components/Shared/PasswordInput.vue'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'
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
