<script setup>
import { ref, watch } from 'vue'
import BaseModal from '@/components/base/BaseModal.vue'

const props = defineProps({
  assunto: { type: Object, default: null },
})
const emit = defineEmits(['save', 'cancel'])

const form = ref({ descricao: '' })
const error = ref('')

watch(() => props.assunto, (val) => {
  form.value = val ? { descricao: val.descricao } : { descricao: '' }
  error.value = ''
}, { immediate: true })

function submit() {
  if (!form.value.descricao.trim()) {
    error.value = 'A descrição é obrigatória.'
    return
  }
  emit('save', { ...form.value })
}
</script>

<template>
  <BaseModal :title="assunto ? 'Editar Assunto' : 'Novo Assunto'" size="sm">
    <div class="mb-3">
      <label class="form-label">Descrição <span class="text-danger">*</span></label>
      <input
        v-model="form.descricao"
        type="text"
        class="form-control"
        :class="{ 'is-invalid': error }"
        maxlength="100"
        placeholder="Descrição do assunto"
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
