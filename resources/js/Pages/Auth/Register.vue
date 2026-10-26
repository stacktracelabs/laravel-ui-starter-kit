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
      <FormControl for="name" label="Name" :error="errors.name" required>
        <Input
          id="name"
          type="text"
          required
          v-focus
          :tabindex="1"
          autocomplete="name"
          name="name"
          placeholder="Full name"
          :aria-invalid="errors.name ? true : undefined"
        />
      </FormControl>

      <FormControl for="email" label="Email address" :error="errors.email" required>
        <Input
          id="email"
          type="email"
          required
          :tabindex="2"
          autocomplete="email"
          name="email"
          placeholder="email@example.com"
          :aria-invalid="errors.email ? true : undefined"
        />
      </FormControl>

      <FormControl for="password" label="Password" :error="errors.password" required>
        <PasswordInput
          id="password"
          required
          :tabindex="3"
          autocomplete="new-password"
          name="password"
          placeholder="Password"
          :passwordrules="passwordRules"
          :aria-invalid="errors.password ? true : undefined"
        />
      </FormControl>

      <FormControl
        for="password_confirmation"
        label="Confirm password"
        :error="errors.password_confirmation"
        required
      >
        <PasswordInput
          id="password_confirmation"
          required
          :tabindex="4"
          autocomplete="new-password"
          name="password_confirmation"
          placeholder="Confirm password"
          :passwordrules="passwordRules"
          :aria-invalid="errors.password_confirmation ? true : undefined"
        />
      </FormControl>

      <Button
        type="submit"
        class="mt-2 w-full"
        tabindex="5"
        :disabled="processing"
        data-test="register-user-button"
      >
        <ButtonState :processing="processing">Create account</ButtonState>
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
import { Button, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import PasswordInput from '@/Components/Shared/PasswordInput.vue'

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
