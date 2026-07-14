<template>
  <Head title="Reset password" />

  <Form
    :action="route('password.update')"
    method="post"
    :transform="(data) => ({ ...data, token, email })"
    :reset-on-success="['password', 'password_confirmation']"
    v-slot="{ errors, processing }"
  >
    <div class="grid gap-6">
      <FormControl for="email" label="Email" :error="errors.email">
        <Input
          id="email"
          type="email"
          name="email"
          autocomplete="email"
          v-model="inputEmail"
          class="mt-1 w-full"
          readonly
          :aria-invalid="errors.email ? true : undefined"
        />
      </FormControl>

      <FormControl for="password" label="Password" :error="errors.password" required>
        <PasswordInput
          id="password"
          name="password"
          autocomplete="new-password"
          class="mt-1 w-full"
          autofocus
          placeholder="Password"
          :passwordrules="passwordRules"
          required
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
          name="password_confirmation"
          autocomplete="new-password"
          class="mt-1 block w-full"
          placeholder="Confirm password"
          :passwordrules="passwordRules"
          required
          :aria-invalid="errors.password_confirmation ? true : undefined"
        />
      </FormControl>

      <Button
        type="submit"
        class="mt-4 w-full"
        :disabled="processing"
        data-test="reset-password-button"
      >
        <ButtonState :processing="processing">Reset password</ButtonState>
      </Button>
    </div>
  </Form>
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Button, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import PasswordInput from '@/Components/Shared/PasswordInput.vue'

defineOptions({
  layout: {
    title: 'Reset password',
    description: 'Please enter your new password below',
  },
})

const props = defineProps<{
  token: string
  email: string
  passwordRules: string
}>()

const inputEmail = ref(props.email)
</script>
