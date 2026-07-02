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
      <div class="grid gap-2">
        <Label for="email">Email</Label>
        <Input
          id="email"
          type="email"
          name="email"
          autocomplete="email"
          v-model="inputEmail"
          class="mt-1 block w-full"
          readonly
        />
        <FormMessage v-if="errors.email" :message="errors.email" class="mt-2" />
      </div>

      <div class="grid gap-2">
        <Label for="password">Password</Label>
        <PasswordInput
          id="password"
          name="password"
          autocomplete="new-password"
          class="mt-1 block w-full"
          autofocus
          placeholder="Password"
          :passwordrules="passwordRules"
        />
        <FormMessage v-if="errors.password" :message="errors.password" />
      </div>

      <div class="grid gap-2">
        <Label for="password_confirmation"> Confirm password </Label>
        <PasswordInput
          id="password_confirmation"
          name="password_confirmation"
          autocomplete="new-password"
          class="mt-1 block w-full"
          placeholder="Confirm password"
          :passwordrules="passwordRules"
        />
        <FormMessage v-if="errors.password_confirmation" :message="errors.password_confirmation" />
      </div>

      <Button
        type="submit"
        class="mt-4 w-full"
        :disabled="processing"
        data-test="reset-password-button"
      >
        <Spinner v-if="processing" />
        Reset password
      </Button>
    </div>
  </Form>
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Button } from '@/Components/Base/Button'
import { FormMessage } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import { Label } from '@/Components/Base/Label'
import { PasswordInput } from '@/Components/Base/PasswordInput'
import { Spinner } from '@/Components/Base/Spinner'

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
