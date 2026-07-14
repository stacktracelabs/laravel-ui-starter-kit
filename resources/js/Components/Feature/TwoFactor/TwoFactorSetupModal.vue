<template>
  <Dialog :open="isOpen" @update:open="isOpen = $event">
    <DialogContent class="sm:max-w-md">
      <DialogHeader class="flex items-center justify-center">
        <div class="mb-3 w-auto rounded-full border border-border bg-card p-0.5 shadow-sm">
          <div class="relative overflow-hidden rounded-full border border-border bg-muted p-2.5">
            <div class="absolute inset-0 grid grid-cols-5 opacity-50">
              <div
                v-for="i in 5"
                :key="`col-${i}`"
                class="border-r border-border last:border-r-0"
              />
            </div>
            <div class="absolute inset-0 grid grid-rows-5 opacity-50">
              <div
                v-for="i in 5"
                :key="`row-${i}`"
                class="border-b border-border last:border-b-0"
              />
            </div>
            <ScanLine class="relative z-20 size-6 text-foreground" />
          </div>
        </div>
        <DialogTitle>{{ modalConfig.title }}</DialogTitle>
        <DialogDescription class="text-center">
          {{ modalConfig.description }}
        </DialogDescription>
      </DialogHeader>

      <div class="relative flex w-auto flex-col items-center justify-center space-y-5">
        <template v-if="!showVerificationStep">
          <Alert v-if="errors?.length" variant="destructive">
            <TriangleAlertIcon aria-hidden="true" />
            <AlertTitle>Two-factor setup unavailable</AlertTitle>
            <AlertDescription>
              <ul class="list-disc space-y-1 pl-4">
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </AlertDescription>
          </Alert>
          <template v-else>
            <div class="relative mx-auto flex max-w-md items-center overflow-hidden">
              <div
                class="relative mx-auto aspect-square w-64 overflow-hidden rounded-lg border border-border"
              >
                <div
                  v-if="!qrCodeSvg"
                  class="absolute inset-0 z-10 flex aspect-square h-auto w-full animate-pulse items-center justify-center bg-background"
                >
                  <Spinner class="size-6" />
                </div>
                <div v-else class="relative z-10 overflow-hidden border p-5">
                  <div
                    v-html="qrCodeSvg"
                    class="flex aspect-square size-full items-center justify-center"
                    :style="{
                      filter:
                        resolvedAppearance === 'dark' ? 'invert(1) brightness(1.5)' : undefined,
                    }"
                  />
                </div>
              </div>
            </div>

            <div class="flex w-full items-center gap-5">
              <Button class="w-full" @click="handleModalNextStep">
                {{ modalConfig.buttonText }}
              </Button>
            </div>

            <div class="relative flex w-full items-center justify-center">
              <div class="absolute inset-0 top-1/2 h-px w-full bg-border" />
              <span class="relative bg-card px-2 py-1">or, enter the code manually</span>
            </div>

            <Field class="w-full">
              <FieldLabel for="manual-setup-key">Manual setup key</FieldLabel>
              <InputGroup>
                <div
                  v-if="!manualSetupKey"
                  class="flex h-full w-full items-center justify-center bg-muted p-3"
                >
                  <Spinner />
                </div>
                <template v-else>
                  <InputGroupInput
                    id="manual-setup-key"
                    type="text"
                    readonly
                    :value="manualSetupKey"
                    aria-label="Manual two-factor setup key"
                  />
                  <InputGroupAddon align="inline-end">
                    <InputGroupButton
                      type="button"
                      size="icon-xs"
                      :aria-label="copied ? 'Setup key copied' : 'Copy setup key'"
                      @click="copy(manualSetupKey || '')"
                    >
                      <Check v-if="copied" class="text-green-600" aria-hidden="true" />
                      <Copy v-else aria-hidden="true" />
                    </InputGroupButton>
                  </InputGroupAddon>
                </template>
              </InputGroup>
            </Field>
          </template>
        </template>

        <template v-else>
          <Form
            :action="route('two-factor.confirm')"
            method="post"
            error-bag="confirmTwoFactorAuthentication"
            reset-on-error
            @finish="code = ''"
            @success="isOpen = false"
            v-slot="{ errors, processing }"
          >
            <div ref="pinInputContainerRef" class="relative w-full space-y-3">
              <Field
                class="items-center py-2 text-center"
                :data-invalid="errors?.code ? true : undefined"
              >
                <FieldLabel for="otp">Six-digit authentication code</FieldLabel>
                <InputOTP
                  id="otp"
                  v-model="code"
                  name="code"
                  :maxlength="6"
                  :pattern="REGEXP_ONLY_DIGITS"
                  autocomplete="one-time-code"
                  inputmode="numeric"
                  :disabled="processing"
                  autofocus
                  :aria-invalid="errors?.code ? true : undefined"
                >
                  <InputOTPGroup>
                    <InputOTPSlot v-for="index in 6" :key="index" :index="index - 1" />
                  </InputOTPGroup>
                </InputOTP>
                <FieldError v-if="errors?.code">{{ errors.code }}</FieldError>
              </Field>

              <div class="flex w-full items-center space-x-5">
                <Button
                  type="button"
                  variant="outline"
                  class="w-auto flex-1"
                  @click="showVerificationStep = false"
                  :disabled="processing"
                >
                  Back
                </Button>
                <Button
                  type="submit"
                  class="w-auto flex-1"
                  :disabled="processing || code.length < 6"
                >
                  <ButtonState :processing="processing">Confirm</ButtonState>
                </Button>
              </div>
            </div>
          </Form>
        </template>
      </div>
    </DialogContent>
  </Dialog>
</template>

<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { useClipboard } from '@vueuse/core'
import { Check, Copy, ScanLine, TriangleAlertIcon } from '@lucide/vue'
import { computed, nextTick, ref, useTemplateRef, watch } from 'vue'
import { REGEXP_ONLY_DIGITS } from 'vue-input-otp'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from '@/Components/Base/Dialog'
import { Field, FieldError, FieldLabel } from '@/Components/Base/Field'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from '@/Components/Base/InputGroup'
import { InputOTP, InputOTPGroup, InputOTPSlot } from '@/Components/Base/InputOTP'
import { Spinner } from '@/Components/Base/Spinner'
import { useAppearance, useTwoFactorAuth } from '@/Composables'
import type { TwoFactorConfigContent } from '@/Types'

type Props = {
  requiresConfirmation: boolean
  twoFactorEnabled: boolean
}

const { resolvedAppearance } = useAppearance()

const props = defineProps<Props>()
const isOpen = defineModel<boolean>('isOpen')

const { copy, copied } = useClipboard()
const { qrCodeSvg, manualSetupKey, clearSetupData, fetchSetupData, errors } = useTwoFactorAuth()

const showVerificationStep = ref(false)
const code = ref<string>('')

const pinInputContainerRef = useTemplateRef('pinInputContainerRef')

const modalConfig = computed<TwoFactorConfigContent>(() => {
  if (props.twoFactorEnabled) {
    return {
      title: 'Two-factor authentication enabled',
      description:
        'Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.',
      buttonText: 'Close',
    }
  }

  if (showVerificationStep.value) {
    return {
      title: 'Verify authentication code',
      description: 'Enter the 6-digit code from your authenticator app',
      buttonText: 'Continue',
    }
  }

  return {
    title: 'Enable two-factor authentication',
    description:
      'To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app',
    buttonText: 'Continue',
  }
})

const handleModalNextStep = () => {
  if (props.requiresConfirmation) {
    showVerificationStep.value = true

    nextTick(() => {
      pinInputContainerRef.value?.querySelector('input')?.focus()
    })

    return
  }

  clearSetupData()
  isOpen.value = false
}

const resetModalState = () => {
  if (props.twoFactorEnabled) {
    clearSetupData()
  }

  showVerificationStep.value = false
  code.value = ''
}

watch(
  () => isOpen.value,
  async (isOpen) => {
    if (!isOpen) {
      resetModalState()

      return
    }

    if (!qrCodeSvg.value) {
      await fetchSetupData()
    }
  },
)
</script>
