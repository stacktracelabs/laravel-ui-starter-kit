<template>
  <Head title="Register" />

  <Form
    :action="route('register.store')"
    method="post"
    :reset-on-success="['password', 'password_confirmation']"
    v-slot="{ errors, processing }"
    class="flex flex-col gap-6"
  >
    <div class="grid gap-6">
      <div class="grid gap-2">
        <Label for="name">Name</Label>
        <Input
          id="name"
          type="text"
          required
          autofocus
          :tabindex="1"
          autocomplete="name"
          name="name"
          placeholder="Full name"
        />
        <FormMessage v-if="errors.name" :message="errors.name" />
      </div>

      <div class="grid gap-2">
        <Label for="email">Email address</Label>
        <Input
          id="email"
          type="email"
          required
          :tabindex="2"
          autocomplete="email"
          name="email"
          placeholder="email@example.com"
        />
        <FormMessage v-if="errors.email" :message="errors.email" />
      </div>

      <div class="grid gap-2">
        <Label for="password">Password</Label>
        <PasswordInput
          id="password"
          required
          :tabindex="3"
          autocomplete="new-password"
          name="password"
          placeholder="Password"
          :passwordrules="passwordRules"
        />
        <FormMessage v-if="errors.password" :message="errors.password" />
      </div>

      <div class="grid gap-2">
        <Label for="password_confirmation">Confirm password</Label>
        <PasswordInput
          id="password_confirmation"
          required
          :tabindex="4"
          autocomplete="new-password"
          name="password_confirmation"
          placeholder="Confirm password"
          :passwordrules="passwordRules"
        />
        <FormMessage v-if="errors.password_confirmation" :message="errors.password_confirmation" />
      </div>

      <Button
        type="submit"
        class="mt-2 w-full"
        tabindex="5"
        :processing="processing"
        :disabled="processing"
        data-test="register-user-button"
      >
        Create account
      </Button>
    </div>

    <div class="text-center text-sm text-muted-foreground">
      Already have an account?
      <Link
        :href="route('login')"
        class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
        :tabindex="6"
      >
        Log in
      </Link>
    </div>
  </Form>
</template>

<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3'
import { Button } from '@/Components/Base/Button'
import { FormMessage } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import { Label } from '@/Components/Base/Label'
import { PasswordInput } from '@/Components/Base/PasswordInput'

defineProps<{
  passwordRules: string
}>()

defineOptions({
  layout: {
    title: 'Create an account',
    description: 'Enter your details below to create your account',
  },
})
</script>
