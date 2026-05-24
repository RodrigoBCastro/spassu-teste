<script setup>
import { ref, watch } from 'vue'
import BaseModal from '@/components/base/BaseModal.vue'

const props = defineProps({
  autor: { type: Object, default: null },
})
const emit = defineEmits(['save', 'cancel'])

const form = ref({ nome: '' })
const error = ref('')

watch(() => props.autor, (val) => {
  form.value = val ? { nome: val.nome } : { nome: '' }
  error.value = ''
}, { immediate: true })

function submit() {
  if (!form.value.nome.trim()) {
    error.value = 'O nome é obrigatório.'
    return
  }
  emit('save', { ...form.value })
}
</script>

<template>
  <BaseModal :title="autor ? 'Editar Autor' : 'Novo Autor'" size="sm">
    <div class="mb-3">
      <label class="form-label">Nome <span class="text-danger">*</span></label>
      <input
        v-model="form.nome"
        type="text"
        class="form-control"
        :class="{ 'is-invalid': error }"
        maxlength="40"
        placeholder="Nome do autor"
        @keyup.enter="submit"
      />
      <div v-if="error" class="invalid-feedback">{{ error }}</div>
    </div>
    <template #footer>
      <button class="btn btn-secondary btn-sm" @click="emit('cancel')">Cancelar</button>
      <button class="btn btn-primary btn-sm" @click="submit">Salvar</button>
    </template>
  </BaseModal>
</template>
