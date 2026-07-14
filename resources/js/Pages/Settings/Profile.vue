<template>
  <Head title="Profile settings" />

  <h1 class="sr-only">Profile settings</h1>

  <div class="flex flex-col gap-6">
    <SectionHeading compact title="Profile" description="Update your name and email address" />

    <Form
      :action="route('profile.update')"
      method="patch"
      class="space-y-6"
      v-slot="{ errors, processing }"
    >
      <FormControl for="name" label="Name" :error="errors.name" required>
        <Input
          id="name"
          class="mt-1 block w-full"
          name="name"
          :default-value="user.name"
          required
          autocomplete="name"
          placeholder="Full name"
          :aria-invalid="errors.name ? true : undefined"
        />
      </FormControl>

      <FormControl for="email" label="Email address" :error="errors.email" required>
        <Input
          id="email"
          type="email"
          class="mt-1 block w-full"
          name="email"
          :default-value="user.email"
          required
          autocomplete="username"
          placeholder="Email address"
          :aria-invalid="errors.email ? true : undefined"
        />
      </FormControl>

      <!-- @chisel-email-verification -->
      <Alert
        v-if="page.props.mustVerifyEmail && !user.emailVerifiedAt"
        :variant="page.props.status === 'verification-link-sent' ? 'positive' : 'default'"
      >
        <MailCheckIcon v-if="page.props.status === 'verification-link-sent'" aria-hidden="true" />
        <MailWarningIcon v-else aria-hidden="true" />
        <AlertTitle>
          {{
            page.props.status === 'verification-link-sent'
              ? 'Verification link sent'
              : 'Email address unverified'
          }}
        </AlertTitle>
        <AlertDescription>
          <template v-if="page.props.status === 'verification-link-sent'">
            A new verification link has been sent to your email address.
          </template>
          <template v-else>
            Verify your address to keep your account secure.
            <ButtonLink
              :href="route('verification.send')"
              method="post"
              as="button"
              variant="link"
              class="h-auto p-0 align-baseline"
            >
              <ButtonState>Resend the verification email</ButtonState>
            </ButtonLink>
          </template>
        </AlertDescription>
      </Alert>
      <!-- @end-chisel-email-verification -->

      <div class="flex items-center gap-4">
        <Button type="submit" :disabled="processing" data-test="update-profile-button">
          <ButtonState :processing="processing">Save</ButtonState>
        </Button>
      </div>
    </Form>
  </div>

  <DeleteUser />
</template>

<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3'
import { MailCheckIcon, MailWarningIcon } from '@lucide/vue'
import { computed } from 'vue'
import { DeleteUser } from '@/Components/Feature/Settings'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonLink, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'

const page = usePage()
const user = computed(() => page.props.auth.user!)
</script>
