<template>
  <Card class="w-full">
    <CardHeader>
      <CardTitle class="flex gap-3"> <LockKeyhole class="size-4" />2FA recovery codes </CardTitle>
      <CardDescription>
        Recovery codes let you regain access if you lose your 2FA device. Store them in a secure
        password manager.
      </CardDescription>
    </CardHeader>
    <CardContent>
      <div class="flex flex-col gap-3 select-none sm:flex-row sm:items-center sm:justify-between">
        <Button
          type="button"
          class="w-fit"
          aria-controls="recovery-codes"
          :aria-expanded="isRecoveryCodesVisible"
          @click="toggleRecoveryCodesVisibility"
        >
          <component :is="isRecoveryCodesVisible ? EyeOff : Eye" class="size-4" />
          {{ isRecoveryCodesVisible ? 'Hide' : 'View' }} recovery codes
        </Button>

        <Form
          v-if="isRecoveryCodesVisible && recoveryCodesList.length"
          :action="route('two-factor.regenerate-recovery-codes')"
          method="post"
          :options="{ preserveScroll: true }"
          @success="fetchRecoveryCodes"
          #default="{ processing }"
        >
          <Button variant="secondary" type="submit" :disabled="processing">
            <ButtonState :processing="processing" processing-label="Regenerating recovery codes">
              <RefreshCw aria-hidden="true" /> Regenerate codes
            </ButtonState>
          </Button>
        </Form>
      </div>
      <div
        id="recovery-codes"
        :class="[
          'relative overflow-hidden transition-all duration-300',
          isRecoveryCodesVisible ? 'h-auto opacity-100' : 'h-0 opacity-0',
        ]"
        :aria-hidden="!isRecoveryCodesVisible"
      >
        <div v-if="errors?.length" class="mt-6">
          <Alert variant="destructive">
            <TriangleAlertIcon aria-hidden="true" />
            <AlertTitle>Recovery codes unavailable</AlertTitle>
            <AlertDescription>
              <ul class="list-disc space-y-1 pl-4">
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </AlertDescription>
          </Alert>
        </div>
        <div v-else class="mt-3 space-y-3">
          <div
            ref="recoveryCodeSectionRef"
            class="grid gap-1 rounded-lg bg-muted p-4 font-mono text-sm"
            :aria-busy="!recoveryCodesList.length"
          >
            <div v-if="!recoveryCodesList.length" aria-hidden="true" class="grid gap-2">
              <Skeleton v-for="n in 8" :key="n" class="h-4 motion-reduce:animate-none" />
            </div>
            <div v-else v-for="(code, index) in recoveryCodesList" :key="index">
              {{ code }}
            </div>
          </div>
          <p class="text-xs text-muted-foreground select-none">
            Each recovery code can be used once to access your account and will be removed after
            use. If you need more, click
            <span class="font-bold">Regenerate codes</span> above.
          </p>
        </div>
      </div>
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { Eye, EyeOff, LockKeyhole, RefreshCw, TriangleAlertIcon } from '@lucide/vue'
import { nextTick, ref, useTemplateRef } from 'vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/Base/Alert'
import { Button, ButtonState } from '@/Components/Base/Button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/Base/Card'
import { Skeleton } from '@/Components/Base/Skeleton'
import { useTwoFactorAuth } from '@/Composables'

const { recoveryCodesList, fetchRecoveryCodes, errors } = useTwoFactorAuth()
const isRecoveryCodesVisible = ref<boolean>(false)
const recoveryCodeSectionRef = useTemplateRef('recoveryCodeSectionRef')

const toggleRecoveryCodesVisibility = async () => {
  if (!isRecoveryCodesVisible.value && !recoveryCodesList.value.length) {
    await fetchRecoveryCodes()
  }

  isRecoveryCodesVisible.value = !isRecoveryCodesVisible.value

  if (isRecoveryCodesVisible.value) {
    await nextTick()
    recoveryCodeSectionRef.value?.scrollIntoView({ behavior: 'smooth' })
  }
}
</script>
