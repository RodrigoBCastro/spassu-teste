<script setup>
import { ref, onMounted } from 'vue'
import { useAssuntos } from '@/composables/useAssuntos'
import { useNotification } from '@/composables/useNotification'
import DataTable from '@/components/base/DataTable.vue'
import AssuntoModal from './AssuntoModal.vue'
import ConfirmModal from '@/components/base/ConfirmModal.vue'

const { assuntos, pagination, loading, fetchPaginado, create, update, remove } = useAssuntos()
const { notify } = useNotification()

const showModal = ref(false)
const showConfirm = ref(false)
const editing = ref(null)
const deletingId = ref(null)

const columns = [
  { key: 'id', label: '#', width: '60px', class: 'text-muted' },
  { key: 'descricao', label: 'Descrição' },
]

onMounted(fetchPaginado)

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
      <button class="btn btn-primary btn-sm" title="Adicionar" @click="openCreate">
        <span class="mdi mdi-plus"></span>
      </button>
    </div>

    <DataTable
      :columns="columns"
      :rows="assuntos"
      :pagination="pagination"
      :loading="loading"
      empty-message="Nenhum assunto cadastrado."
      @page-change="(page) => fetchPaginado(page)"
      @per-page-change="(perPage) => fetchPaginado(1, perPage)"
    >
      <template #actions="{ row }">
        <button class="dt-btn-action" title="Editar" @click="openEdit(row)">
          <span class="mdi mdi-pencil-outline"></span>
        </button>
        <button class="dt-btn-action dt-btn-action--danger" title="Excluir" @click="askDelete(row.id)">
          <span class="mdi mdi-trash-can-outline"></span>
        </button>
      </template>
    </DataTable>

    <AssuntoModal v-if="showModal" :assunto="editing" @save="onSave" @cancel="showModal = false" />
    <ConfirmModal v-if="showConfirm" @confirm="onConfirmDelete" @cancel="showConfirm = false" />
  </div>
</template>
