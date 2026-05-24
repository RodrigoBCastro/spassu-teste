<script setup>
import { ref, watch, computed } from 'vue'
import BaseModal from '@/components/base/BaseModal.vue'

const props = defineProps({
  livro: { type: Object, default: null },
  autores: { type: Array, default: () => [] },
  assuntos:{ type: Array, default: () => [] },
})
const emit = defineEmits(['save', 'cancel'])

const form = ref({
  titulo: '', editora: '', edicao: 1,
  ano_publicacao: '', valor: '',
  autores_ids: [], assuntos_ids: [],
})
const errors = ref({})

watch(() => props.livro, (val) => {
  if (val) {
    form.value = {
      titulo: val.titulo,
      editora: val.editora,
      edicao: val.edicao,
      ano_publicacao: val.ano_publicacao,
      valor: val.valor,
      autores_ids: val.autores?.map(a => a.id) ?? [],
      assuntos_ids: val.assuntos?.map(a => a.id) ?? [],
    }
  } else {
    form.value = {
      titulo: '', editora: '', edicao: 1,
      ano_publicacao: '', valor: '',
      autores_ids: [], assuntos_ids: [],
    }
  }
  errors.value = {}
}, { immediate: true })

const valorFormatado = computed({
  get() {
    return form.value.valor
  },
  set(v) {
    form.value.valor = v.replace(/[^0-9.,]/g, '').replace(',', '.')
  },
})

function validate() {
  const e = {}
  if (!form.value.titulo.trim()) e.titulo = 'Obrigatório.'
  if (!form.value.editora.trim()) e.editora = 'Obrigatório.'
  if (!form.value.edicao || form.value.edicao < 1) e.edicao = 'Deve ser >= 1.'
  if (!/^\d{4}$/.test(form.value.ano_publicacao)) e.ano_publicacao = 'Deve ter 4 dígitos.'
  if (!form.value.valor || isNaN(parseFloat(form.value.valor))) e.valor = 'Valor inválido.'
  if (form.value.autores_ids.length === 0) e.autores_ids = 'Selecione ao menos um autor.'
  if (form.value.assuntos_ids.length === 0) e.assuntos_ids = 'Selecione ao menos um assunto.'
  errors.value = e
  return Object.keys(e).length === 0
}

function submit() {
  if (!validate()) return
  emit('save', {
    titulo: form.value.titulo.trim(),
    editora: form.value.editora.trim(),
    edicao: Number(form.value.edicao),
    ano_publicacao: form.value.ano_publicacao,
    valor: parseFloat(String(form.value.valor).replace(',', '.')),
    autores_ids: form.value.autores_ids,
    assuntos_ids: form.value.assuntos_ids,
  })
}
</script>

<template>
  <BaseModal :title="livro ? 'Editar Livro' : 'Novo Livro'" size="lg">
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label">Título <span class="text-danger">*</span></label>
        <input v-model="form.titulo" type="text" class="form-control" :class="{'is-invalid': errors.titulo}" maxlength="40" />
        <div class="invalid-feedback">{{ errors.titulo }}</div>
      </div>

      <div class="col-md-6">
        <label class="form-label">Editora <span class="text-danger">*</span></label>
        <input v-model="form.editora" type="text" class="form-control" :class="{'is-invalid': errors.editora}" maxlength="40" />
        <div class="invalid-feedback">{{ errors.editora }}</div>
      </div>

      <div class="col-md-3">
        <label class="form-label">Edição <span class="text-danger">*</span></label>
        <input v-model.number="form.edicao" type="number" min="1" class="form-control" :class="{'is-invalid': errors.edicao}" />
        <div class="invalid-feedback">{{ errors.edicao }}</div>
      </div>

      <div class="col-md-3">
        <label class="form-label">Ano <span class="text-danger">*</span></label>
        <input v-model="form.ano_publicacao" type="text" maxlength="4" class="form-control" :class="{'is-invalid': errors.ano_publicacao}" placeholder="AAAA" />
        <div class="invalid-feedback">{{ errors.ano_publicacao }}</div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Valor (R$) <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text">R$</span>
          <input v-model="valorFormatado" type="text" inputmode="decimal" class="form-control" :class="{'is-invalid': errors.valor}" placeholder="0,00" />
          <div class="invalid-feedback">{{ errors.valor }}</div>
        </div>
      </div>

      <div class="col-12">
        <label class="form-label">Autores <span class="text-danger">*</span></label>
        <div class="form-check-group" :class="{'border-danger': errors.autores_ids}">
          <div v-for="autor in autores" :key="autor.id" class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              :id="`autor-${autor.id}`"
              :value="autor.id"
              v-model="form.autores_ids"
            />
            <label class="form-check-label" :for="`autor-${autor.id}`">{{ autor.nome }}</label>
          </div>
        </div>
        <div v-if="errors.autores_ids" class="text-danger" style="font-size:0.8rem;margin-top:4px">{{ errors.autores_ids }}</div>
      </div>

      <div class="col-12">
        <label class="form-label">Assuntos <span class="text-danger">*</span></label>
        <div class="form-check-group" :class="{'border-danger': errors.assuntos_ids}">
          <div v-for="assunto in assuntos" :key="assunto.id" class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              :id="`assunto-${assunto.id}`"
              :value="assunto.id"
              v-model="form.assuntos_ids"
            />
            <label class="form-check-label" :for="`assunto-${assunto.id}`">{{ assunto.descricao }}</label>
          </div>
        </div>
        <div v-if="errors.assuntos_ids" class="text-danger" style="font-size:0.8rem;margin-top:4px">{{ errors.assuntos_ids }}</div>
      </div>
    </div>

    <template #footer>
      <button class="btn btn-secondary btn-sm" @click="emit('cancel')">Cancelar</button>
      <button class="btn btn-primary btn-sm" @click="submit">Salvar</button>
    </template>
  </BaseModal>
</template>
