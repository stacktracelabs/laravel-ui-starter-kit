<template>
  <InputGroup :class="props.class">
    <InputGroupInput
      v-focus="props.autofocus"
      ref="inputRef"
      :type="isPasswordVisible ? 'text' : 'password'"
      v-bind="$attrs"
    />
    <InputGroupAddon align="inline-end">
      <InputGroupButton
        type="button"
        size="icon-xs"
        :aria-label="isPasswordVisible ? 'Hide password' : 'Show password'"
        @click="isPasswordVisible = !isPasswordVisible"
      >
        <EyeOffIcon v-if="isPasswordVisible" aria-hidden="true" />
        <EyeIcon v-else aria-hidden="true" />
      </InputGroupButton>
    </InputGroupAddon>
  </InputGroup>
</template>

<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { EyeIcon, EyeOffIcon } from '@lucide/vue'
import { ref, useTemplateRef } from 'vue'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from '@/Components/Base/InputGroup'

defineOptions({ inheritAttrs: false })

const props = defineProps<{
  class?: HTMLAttributes['class']
  autofocus?: boolean
}>()

const isPasswordVisible = ref(false)
const inputRef = useTemplateRef('inputRef')

defineExpose({
  focus: () => inputRef.value?.$el?.focus(),
})
</script>
