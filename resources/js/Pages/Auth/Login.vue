<template>
  <Head title="Log in" />

  <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
    {{ status }}
  </div>

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
      <div class="grid gap-2">
        <Label for="email">Email address</Label>
        <Input
          id="email"
          type="email"
          name="email"
          required
          autofocus
          :tabindex="1"
          autocomplete="email"
          placeholder="email@example.com"
        />
        <FormMessage v-if="errors.email" :message="errors.email" />
      </div>

      <div class="grid gap-2">
        <div class="flex items-center justify-between">
          <Label for="password">Password</Label>
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
        />
        <FormMessage v-if="errors.password" :message="errors.password" />
      </div>

      <div class="flex items-center justify-between">
        <Label for="remember" class="flex items-center space-x-3">
          <Checkbox id="remember" name="remember" :tabindex="3" />
          <span>Remember me</span>
        </Label>
      </div>

      <Button
        type="submit"
        class="mt-4 w-full"
        :tabindex="4"
        :processing="processing"
        :disabled="processing"
        data-test="login-button"
      >
        Log in
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
import { Button } from '@/Components/Base/Button'
import { Checkbox } from '@/Components/Base/Checkbox'
import { FormMessage } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import { Label } from '@/Components/Base/Label'
import { PasswordInput } from '@/Components/Base/PasswordInput'
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
