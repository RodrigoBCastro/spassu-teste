<script setup>
import { ref, onMounted } from 'vue'
import { useAutores } from '@/composables/useAutores'
import { useNotification } from '@/composables/useNotification'
import DataTable from '@/components/base/DataTable.vue'
import AutorModal from './AutorModal.vue'
import ConfirmModal from '@/components/base/ConfirmModal.vue'

const { autores, pagination, loading, fetchPaginado, create, update, remove } = useAutores()
const { notify } = useNotification()

const showModal = ref(false)
const showConfirm = ref(false)
const editing = ref(null)
const deletingId = ref(null)

const columns = [
  { key: 'id', label: '#', width: '60px', class: 'text-muted' },
  { key: 'nome', label: 'Nome' },
]

onMounted(fetchPaginado)

function openCreate() {
  editing.value = null
  showModal.value = true
}

function openEdit(autor) {
  editing.value = { ...autor }
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
    notify(e.response?.data?.message ?? 'Erro ao salvar autor.', 'error')
  }
}

async function onConfirmDelete() {
  try {
    await remove(deletingId.value)
  } catch (e) {
    notify(e.response?.data?.message ?? 'Erro ao remover autor.', 'error')
  } finally {
    showConfirm.value = false
  }
}
</script>

<template>
  <div>
    <div class="section-header">
      <h4>Autores</h4>
      <button class="btn btn-primary btn-sm" title="Adicionar" @click="openCreate">
        <span class="mdi mdi-plus"></span>
      </button>
    </div>

    <DataTable
      :columns="columns"
      :rows="autores"
      :pagination="pagination"
      :loading="loading"
      empty-message="Nenhum autor cadastrado."
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

    <AutorModal v-if="showModal" :autor="editing" @save="onSave" @cancel="showModal = false" />
    <ConfirmModal v-if="showConfirm" @confirm="onConfirmDelete" @cancel="showConfirm = false" />
  </div>
</template>
