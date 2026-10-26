<template>
  <Alert v-if="!isSupported">
    <InfoIcon aria-hidden="true" />
    <AlertTitle>Passkeys unavailable</AlertTitle>
    <AlertDescription>This browser does not support passkeys.</AlertDescription>
  </Alert>

  <Button v-else-if="!showForm" type="button" variant="outline" @click="showForm = true">
    Add passkey
  </Button>

  <form v-else @submit.prevent="handleSubmit" class="space-y-4 rounded-lg border bg-muted/30 p-4">
    <FormControl
      for="passkey-name"
      label="Passkey name"
      help="Use a name that helps you identify this passkey later."
      required
    >
      <Input
        id="passkey-name"
        type="text"
        v-model="name"
        placeholder="e.g., MacBook Pro, iPhone"
        class="mt-1 block w-full border-foreground/20"
        :disabled="isLoading"
        v-focus
        required
      />
    </FormControl>

    <Alert v-if="error" variant="destructive">
      <TriangleAlertIcon aria-hidden="true" />
      <AlertTitle>Passkey registration failed</AlertTitle>
      <AlertDescription>{{ error }}</AlertDescription>
    </Alert>

    <div class="flex gap-2">
      <Button type="submit" :disabled="isLoading || !name.trim()">
        <ButtonState :processing="isLoading" processing-label="Registering passkey">
          Register passkey
        </ButtonState>
      </Button>
      <Button type="button" variant="outline" :disabled="isLoading" @click="handleCancel">
        Cancel
      </Button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { usePasskeyRegister } from '@laravel/passkeys/vue'
import { InfoIcon, TriangleAlertIcon } from '@lucide/vue'
import { ref } from 'vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import { FormControl } from '@/Components/Base/Form'
import { Input } from '@/Components/Base/Input'

const emit = defineEmits<{
  success: []
}>()

const getDefaultPasskeyName = (): string => {
  const ua = navigator.userAgent

  const browser = [
    { pattern: /Edg|Edge/, name: 'Edge' },
    { pattern: /OPR|Opera|OPiOS/, name: 'Opera' },
    { pattern: /Firefox|FxiOS/, name: 'Firefox' },
    { pattern: /Chrome|CriOS/, name: 'Chrome' },
    { pattern: /Safari/, name: 'Safari' },
  ].find(({ pattern }) => pattern.test(ua))?.name

  const os = [
    { pattern: /iPhone/, name: 'iPhone' },
    { pattern: /iPad|Macintosh(?=.*Mobile)/, name: 'iPad' },
    { pattern: /Android/, name: 'Android' },
    { pattern: /Mac/, name: 'Mac' },
    { pattern: /Windows/, name: 'Windows' },
  ].find(({ pattern }) => pattern.test(ua))?.name

  return [browser, os].filter(Boolean).join(' on ') || ''
}

const defaultPasskeyName = getDefaultPasskeyName()
const name = ref(defaultPasskeyName)
const showForm = ref(false)

const { register, isLoading, error, isSupported } = usePasskeyRegister({
  onSuccess: () => {
    name.value = defaultPasskeyName
    error.value = null
    showForm.value = false
    emit('success')
  },
})

const handleSubmit = async (): Promise<void> => {
  if (!name.value.trim()) {
    return
  }

  await register(name.value.trim())
}

const handleCancel = (): void => {
  showForm.value = false
  name.value = defaultPasskeyName
  error.value = null
}
</script>
