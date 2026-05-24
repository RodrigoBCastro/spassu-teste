<script setup>
import { ref, onMounted } from 'vue'
import { useAutores } from '@/composables/useAutores'
import { useNotification } from '@/composables/useNotification'
import AutorModal from './AutorModal.vue'
import ConfirmModal from '@/components/base/ConfirmModal.vue'

const { autores, loading, fetchAll, create, update, remove } = useAutores()
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
      <button class="btn btn-primary btn-sm" title="Adicionar" @click="openCreate"><span class="mdi mdi-plus"></span></button>
    </div>

    <div v-if="loading" class="loading-state">Carregando...</div>

    <div v-else-if="autores.length === 0" class="empty-state">
      Nenhum autor cadastrado.
    </div>

    <div v-else class="table-wrapper">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th class="text-end">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="autor in autores" :key="autor.id">
            <td class="text-muted" style="width:60px">{{ autor.id }}</td>
            <td>{{ autor.nome }}</td>
            <td class="text-end" style="width:120px">
              <button class="btn-action btn btn-sm btn-outline-secondary me-1" title="Editar" @click="openEdit(autor)">
                <span class="mdi mdi-pencil-outline"></span>
              </button>
              <button class="btn-action btn btn-sm btn-outline-danger" title="Excluir" @click="askDelete(autor.id)">
                <span class="mdi mdi-trash-can-outline"></span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <AutorModal v-if="showModal" :autor="editing" @save="onSave" @cancel="showModal = false"/>
    <ConfirmModal v-if="showConfirm" @confirm="onConfirmDelete" @cancel="showConfirm = false"/>
  </div>
</template>
