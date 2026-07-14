<template>
  <div v-if="canManagePasskeys" class="space-y-6">
    <SectionHeading
      compact
      title="Passkeys"
      description="Manage your passkeys for passwordless sign-in"
    />

    <ItemGroup v-if="passkeys.length" class="overflow-hidden rounded-lg border">
      <PasskeyItem v-for="passkey in passkeys" :key="passkey.id" :passkey="passkey" />
    </ItemGroup>

    <Empty v-else class="border border-dashed">
      <EmptyHeader>
        <EmptyMedia variant="icon"><KeyRound aria-hidden="true" /></EmptyMedia>
        <EmptyTitle>No passkeys yet</EmptyTitle>
        <EmptyDescription>Add a passkey to sign in without a password.</EmptyDescription>
      </EmptyHeader>
    </Empty>

    <PasskeyRegister @success="handleRegisterSuccess" />
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { KeyRound } from '@lucide/vue'
import { PasskeyItem, PasskeyRegister } from '@/Components/Feature/Passkeys'
import {
  Empty,
  EmptyDescription,
  EmptyHeader,
  EmptyMedia,
  EmptyTitle,
} from '@/Components/Base/Empty'
import { ItemGroup } from '@/Components/Base/Item'
import SectionHeading from '@/Components/Shared/SectionHeading.vue'
import type { ManagePasskeysProps } from './types'

withDefaults(defineProps<ManagePasskeysProps>(), {
  canManagePasskeys: false,
  passkeys: () => [],
})

const handleRegisterSuccess = (): void => {
  router.reload({ only: ['passkeys'] })
}
</script>
