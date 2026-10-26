<template>
  <Head title="Log in" />

  <Alert v-if="status" variant="positive">
    <CircleCheckIcon aria-hidden="true" />
    <AlertTitle>Request completed</AlertTitle>
    <AlertDescription>{{ status }}</AlertDescription>
  </Alert>

  <!-- @chisel-passkeys -->
  <PasskeyVerify />
  <!-- @end-chisel-passkeys -->

  <Form
    :action="route('login.store')"
    method="post"
    :reset-on-success="['password']"
    v-slot="{ errors, processing }"
    class="flex flex-col gap-6"
  >
    <div class="grid gap-6">
      <FormControl for="email" label="Email address" :error="errors.email" required>
        <Input
          id="email"
          type="email"
          name="email"
          required
          v-focus
          :tabindex="1"
          autocomplete="email"
          placeholder="email@example.com"
          :aria-invalid="errors.email ? true : undefined"
        />
      </FormControl>

      <Field :data-invalid="errors.password ? true : undefined">
        <div class="flex items-center justify-between">
          <FieldLabel for="password">Password</FieldLabel>
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
            :tabindex="5"
          >
            Forgot your password?
          </Link>
        </div>
        <PasswordInput
          id="password"
          name="password"
          required
          :tabindex="2"
          autocomplete="current-password"
          placeholder="Password"
          :aria-invalid="errors.password ? true : undefined"
        />
        <FieldError v-if="errors.password">{{ errors.password }}</FieldError>
      </Field>

      <div class="flex items-center justify-between">
        <Label for="remember" class="flex items-center gap-3">
          <Checkbox id="remember" name="remember" :tabindex="3" />
          <span>Remember me</span>
        </Label>
      </div>

      <Button
        type="submit"
        class="mt-4 w-full"
        :tabindex="4"
        :disabled="processing"
        data-test="login-button"
      >
        <ButtonState :processing="processing">Log in</ButtonState>
      </Button>
    </div>

    <!-- @chisel-registration -->
    <div class="text-center text-sm text-muted-foreground">
      Don't have an account?
      <Link
        :href="route('register')"
        :tabindex="5"
        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
      >
        Sign up
      </Link>
    </div>
    <!-- @end-chisel-registration -->
  </Form>
</template>

<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3'
import { CircleCheckIcon } from '@lucide/vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import { Checkbox } from '@/Components/Base/Checkbox'
import { Field, FieldError, FieldLabel } from '@/Components/Base/Field'
import { FormControl } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import { Label } from '@/Components/Base/Label'
import PasswordInput from '@/Components/Shared/PasswordInput.vue'
/* @chisel-registration */
/* @end-chisel-registration */
/* @chisel-passkeys */
import { PasskeyVerify } from '@/Components/Feature/Auth'
/* @end-chisel-passkeys */

defineOptions({
  layout: {
    title: 'Log in to your account',
    description: 'Enter your email and password below to log in',
  },
})

defineProps<{
  status?: string
  canResetPassword: boolean
}>()
</script>
