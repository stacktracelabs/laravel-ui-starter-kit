<template>
  <Head title="Profile settings" />

  <h1 class="sr-only">Profile settings</h1>

  <div class="flex flex-col space-y-6">
    <Heading variant="small" title="Profile" description="Update your name and email address" />

    <Form
      :action="route('profile.update')"
      method="patch"
      class="space-y-6"
      v-slot="{ errors, processing }"
    >
      <div class="grid gap-2">
        <Label for="name">Name</Label>
        <Input
          id="name"
          class="mt-1 block w-full"
          name="name"
          :default-value="user.name"
          required
          autocomplete="name"
          placeholder="Full name"
        />
        <FormMessage v-if="errors.name" class="mt-2" :message="errors.name" />
      </div>

      <div class="grid gap-2">
        <Label for="email">Email address</Label>
        <Input
          id="email"
          type="email"
          class="mt-1 block w-full"
          name="email"
          :default-value="user.email"
          required
          autocomplete="username"
          placeholder="Email address"
        />
        <FormMessage v-if="errors.email" class="mt-2" :message="errors.email" />
      </div>

      <!-- @chisel-email-verification -->
      <div v-if="page.props.mustVerifyEmail && !user.email_verified_at">
        <p class="-mt-4 text-sm text-muted-foreground">
          Your email address is unverified.
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
          >
            Click here to re-send the verification email.
          </Link>
        </p>

        <div
          v-if="page.props.status === 'verification-link-sent'"
          class="mt-2 text-sm font-medium text-green-600"
        >
          A new verification link has been sent to your email address.
        </div>
      </div>
      <!-- @end-chisel-email-verification -->

      <div class="flex items-center gap-4">
        <Button :processing="processing" :disabled="processing" data-test="update-profile-button">
          Save
        </Button>
      </div>
    </Form>
  </div>

  <DeleteUser />
</template>

<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3'
/* @chisel-email-verification */
import { Link } from '@inertiajs/vue3'
/* @end-chisel-email-verification */
import { computed } from 'vue'
import { DeleteUser } from '@/Components/Feature/Settings'
import { Button } from '@/Components/Base/Button'
import { FormMessage } from '@/Components/Base/Form'
import { Heading } from '@/Components/Base/Heading'
import { Input } from '@/Components/Base/Input'
import { Label } from '@/Components/Base/Label'
/* @chisel-email-verification */
/* @end-chisel-email-verification */

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>
