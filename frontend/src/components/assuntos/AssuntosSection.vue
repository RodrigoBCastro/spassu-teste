<script setup>
import { ref, onMounted } from 'vue'
import { useAssuntos } from '@/composables/useAssuntos'
import { useNotification } from '@/composables/useNotification'
import AssuntoModal from './AssuntoModal.vue'
import ConfirmModal from '@/components/base/ConfirmModal.vue'

const { assuntos, loading, fetchAll, create, update, remove } = useAssuntos()
const { notify } = useNotification()

const showModal = ref(false)
const showConfirm = ref(false)
const editing = ref(null)
const deletingId = ref(null)

onMounted(fetchAll)

function openCreate() {
  editing.value = null
  showModal.value = true
}

function openEdit(assunto) {
  editing.value = { ...assunto }
  showModal.value = true
}

function askDelete(id) {
  deletingId.value = id
  showConfirm.value = true
}

async function onSave(payload) {
  try {
    if (editing.value) {
      await update(editing.value.id, payload)
    } else {
      await create(payload)
    }
    showModal.value = false
  } catch (e) {
    notify(e.response?.data?.message ?? 'Erro ao salvar assunto.', 'error')
  }
}

async function onConfirmDelete() {
  try {
    await remove(deletingId.value)
  } catch (e) {
    notify(e.response?.data?.message ?? 'Erro ao remover assunto.', 'error')
  } finally {
    showConfirm.value = false
  }
}
</script>

<template>
  <div>
    <div class="section-header">
      <h4>Assuntos</h4>
      <button class="btn btn-primary btn-sm" title="Adicionar" @click="openCreate"><span class="mdi mdi-plus"></span></button>
    </div>

    <div v-if="loading" class="loading-state">Carregando...</div>

    <div v-else-if="assuntos.length === 0" class="empty-state">
      Nenhum assunto cadastrado.
    </div>

    <div v-else class="table-wrapper">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Descrição</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="assunto in assuntos" :key="assunto.id">
            <td class="text-muted" style="width:60px">{{ assunto.id }}</td>
            <td>{{ assunto.descricao }}</td>
            <td class="text-end" style="width:120px">
              <button class="btn-action btn btn-sm btn-outline-secondary me-1" title="Editar" @click="openEdit(assunto)">
                <span class="mdi mdi-pencil-outline"></span>
              </button>
              <button class="btn-action btn btn-sm btn-outline-danger" title="Excluir" @click="askDelete(assunto.id)">
                <span class="mdi mdi-trash-can-outline"></span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <AssuntoModal v-if="showModal" :assunto="editing" @save="onSave" @cancel="showModal = false"/>
    <ConfirmModal v-if="showConfirm" @confirm="onConfirmDelete" @cancel="showConfirm = false"/>
  </div>
</template>
