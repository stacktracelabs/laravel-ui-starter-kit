<template>
  <div v-if="canManageTwoFactor" class="space-y-6">
    <SectionHeading
      compact
      title="Two-factor authentication"
      description="Manage your two-factor authentication settings"
    />

    <div v-if="!twoFactorEnabled" class="flex flex-col items-start justify-start space-y-4">
      <p class="text-sm text-muted-foreground">
        When you enable two-factor authentication, you will be prompted for a secure pin during
        login. This pin can be retrieved from a TOTP-supported application on your phone.
      </p>

      <div>
        <Button v-if="hasSetupData" type="button" @click="showSetupModal = true">
          <ShieldCheck />Continue setup
        </Button>
        <Form
          v-else
          :action="route('two-factor.enable')"
          method="post"
          @success="showSetupModal = true"
          #default="{ processing }"
        >
          <Button type="submit" :disabled="processing">
            <ButtonState :processing="processing">Enable 2FA</ButtonState>
          </Button>
        </Form>
      </div>
    </div>

    <div v-else class="flex flex-col items-start justify-start space-y-4">
      <p class="text-sm text-muted-foreground">
        You will be prompted for a secure, random pin during login, which you can retrieve from the
        TOTP-supported application on your phone.
      </p>

      <div class="relative inline">
        <Form :action="route('two-factor.disable')" method="delete" #default="{ processing }">
          <Button variant="destructive" type="submit" :disabled="processing">
            <ButtonState :processing="processing">Disable 2FA</ButtonState>
          </Button>
        </Form>
      </div>

      <TwoFactorRecoveryCodes />
    </div>

    <TwoFactorSetupModal
      v-model:isOpen="showSetupModal"
      :requiresConfirmation="requiresConfirmation"
      :twoFactorEnabled="twoFactorEnabled"
    />
  </div>
</template>

<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { ShieldCheck } from '@lucide/vue'
import { onUnmounted, ref } from 'vue'
import { TwoFactorRecoveryCodes } from '@/Components/Feature/TwoFactor'
import { TwoFactorSetupModal } from '@/Components/Feature/TwoFactor'
import { Button, ButtonState } from '@/Components/Base/Button'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'
import { useTwoFactorAuth } from '@/Composables'
import type { ManageTwoFactorProps } from './types'

withDefaults(defineProps<ManageTwoFactorProps>(), {
  canManageTwoFactor: false,
  requiresConfirmation: false,
  twoFactorEnabled: false,
})

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth()
const showSetupModal = ref<boolean>(false)

onUnmounted(() => clearTwoFactorAuthData())
</script>
