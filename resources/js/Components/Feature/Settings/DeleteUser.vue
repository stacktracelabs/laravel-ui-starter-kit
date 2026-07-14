<template>
  <div class="space-y-6">
    <SectionHeading
      compact
      title="Delete account"
      description="Delete your account and all of its resources"
    />
    <Alert variant="destructive">
      <TriangleAlertIcon aria-hidden="true" />
      <AlertTitle>Permanent action</AlertTitle>
      <AlertDescription>
        Deleting your account removes all of its resources and cannot be undone.
      </AlertDescription>
    </Alert>
    <div>
      <Dialog>
        <DialogTrigger as-child>
          <Button variant="destructive" data-test="delete-user-button">Delete account</Button>
        </DialogTrigger>
        <DialogContent>
          <Form
            :action="route('profile.destroy')"
            method="delete"
            reset-on-success
            @error="() => passwordInput?.focus()"
            :options="{
              preserveScroll: true,
            }"
            class="space-y-6"
            v-slot="{ errors, processing, reset, clearErrors }"
          >
            <DialogHeader class="space-y-3">
              <DialogTitle>Are you sure you want to delete your account?</DialogTitle>
              <DialogDescription>
                Once your account is deleted, all of its resources and data will also be permanently
                deleted. Please enter your password to confirm you would like to permanently delete
                your account.
              </DialogDescription>
            </DialogHeader>

            <FormControl for="password" label="Password" :error="errors.password" required>
              <PasswordInput
                id="password"
                name="password"
                ref="passwordInput"
                placeholder="Password"
                required
                :aria-invalid="errors.password ? true : undefined"
              />
            </FormControl>

            <DialogFooter class="gap-2">
              <DialogClose as-child>
                <Button
                  type="button"
                  variant="outline"
                  @click="
                    () => {
                      clearErrors()
                      reset()
                    }
                  "
                >
                  Cancel
                </Button>
              </DialogClose>

              <Button
                type="submit"
                variant="destructive"
                :disabled="processing"
                data-test="confirm-delete-user-button"
              >
                <ButtonState :processing="processing">Delete account</ButtonState>
              </Button>
            </DialogFooter>
          </Form>
        </DialogContent>
      </Dialog>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { TriangleAlertIcon } from '@lucide/vue'
import { useTemplateRef } from 'vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/Components/Base/Dialog'
import { FormControl } from '@/Components/Base/Form'
import PasswordInput from '@/Components/Shared/PasswordInput.vue'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'

const passwordInput = useTemplateRef('passwordInput')
</script>
