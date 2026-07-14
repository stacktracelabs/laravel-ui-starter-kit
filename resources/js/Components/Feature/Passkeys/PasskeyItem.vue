<template>
  <Item role="listitem">
    <ItemMedia variant="icon"><KeyRound aria-hidden="true" /></ItemMedia>
    <ItemContent>
      <div class="flex flex-wrap items-center gap-2">
        <ItemTitle>{{ passkey.name }}</ItemTitle>
        <Badge v-if="passkey.authenticator" variant="outline">
          {{ passkey.authenticator }}
        </Badge>
      </div>
      <ItemDescription>
        Added {{ passkey.createdAtDiff }}
        <template v-if="passkey.lastUsedAtDiff">
          · Last used {{ passkey.lastUsedAtDiff }}
        </template>
      </ItemDescription>
    </ItemContent>

    <ItemActions>
      <Button
        variant="ghost"
        size="icon-sm"
        :aria-label="`Remove ${passkey.name} passkey`"
        class="text-destructive hover:bg-destructive/10 hover:text-destructive"
        @click="requestDeletion"
      >
        <Trash2 aria-hidden="true" />
      </Button>
    </ItemActions>
  </Item>
</template>

<script setup lang="ts">
import { asyncRouter } from '@stacktrace/ui'
import { KeyRound, Trash2 } from '@lucide/vue'
import { toast } from 'vue-sonner'
import { route } from 'ziggy-js'
import { Badge } from '@/Components/Base/Badge'
import { Button } from '@/Components/Base/Button'
import { useConfirmable } from '@/Components/Base/ConfirmationDialog'
import {
  Item,
  ItemActions,
  ItemContent,
  ItemDescription,
  ItemMedia,
  ItemTitle,
} from '@/Components/Base/Item'
import type { Passkey } from '@/Types'

const props = defineProps<{
  passkey: Passkey
}>()

const { confirm } = useConfirmable()

const requestDeletion = (): void => {
  confirm({
    type: 'confirmation',
    title: 'Remove passkey?',
    message: `You will no longer be able to use “${props.passkey.name}” to sign in.`,
    cancelLabel: 'Keep passkey',
    confirmLabel: 'Remove passkey',
    destructive: true,
    confirm: async () => {
      try {
        await asyncRouter.delete(route('passkey.destroy', props.passkey.id), {
          preserveScroll: true,
        })
      } catch {
        toast.error('Passkey could not be removed', {
          description: 'Please try again.',
        })
      }
    },
  })
}
</script>
