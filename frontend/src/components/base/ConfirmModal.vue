<script setup>
import BaseModal from './BaseModal.vue'

defineProps({
  message: { type: String, default: 'Tem certeza que deseja excluir este registro?' },
})
const emit = defineEmits(['confirm', 'cancel'])
</script>

<template>
  <BaseModal title="Confirmar exclusão" size="sm">
    <p class="mb-0">{{ message }}</p>
    <template #footer>
      <button class="btn btn-secondary btn-sm" @click="emit('cancel')">Cancelar</button>
      <button class="btn btn-danger btn-sm" @click="emit('confirm')">Excluir</button>
    </template>
  </BaseModal>
</template>
