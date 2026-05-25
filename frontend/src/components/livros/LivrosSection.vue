<script setup>
import { ref, onMounted } from 'vue'
import { useLivros } from '@/composables/useLivros'
import { useAutores } from '@/composables/useAutores'
import { useAssuntos } from '@/composables/useAssuntos'
import { useNotification } from '@/composables/useNotification'
import DataTable from '@/components/base/DataTable.vue'
import LivroModal from './LivroModal.vue'
import ConfirmModal from '@/components/base/ConfirmModal.vue'

const { livros, pagination, loading, fetchPaginado, create, update, remove } = useLivros()
const { autores, fetchTodos: fetchAutores } = useAutores()
const { assuntos, fetchTodos: fetchAssuntos } = useAssuntos()
const { notify } = useNotification()

const showModal = ref(false)
const showConfirm = ref(false)
const editing = ref(null)
const deletingId = ref(null)

const columns = [
  { key: 'titulo', label: 'Título' },
  { key: 'editora', label: 'Editora' },
  { key: 'edicao', label: 'Ed.', width: '60px' },
  { key: 'ano_publicacao', label: 'Ano', width: '70px' },
  { key: 'valor', label: 'Valor', width: '110px' },
  { key: 'autores', label: 'Autores' },
  { key: 'assuntos', label: 'Assuntos' },
]

onMounted(async () => {
  await Promise.all([fetchPaginado(), fetchAutores(), fetchAssuntos()])
})

function openCreate() {
  editing.value = null
  showModal.value = true
}

function openEdit(livro) {
  editing.value = { ...livro }
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
    notify(e.response?.data?.message ?? 'Erro ao salvar livro.', 'error')
  }
}

async function onConfirmDelete() {
  try {
    await remove(deletingId.value)
  } catch (e) {
    notify(e.response?.data?.message ?? 'Erro ao remover livro.', 'error')
  } finally {
    showConfirm.value = false
  }
}

function formatCurrency(val) {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(val)
}
</script>

<template>
  <div>
    <div class="section-header">
      <h4>Livros</h4>
      <button class="btn btn-primary btn-sm" title="Adicionar" @click="openCreate">
        <span class="mdi mdi-plus"></span>
      </button>
    </div>

    <DataTable
      :columns="columns"
      :rows="livros"
      :pagination="pagination"
      :loading="loading"
      empty-message="Nenhum livro cadastrado."
      @page-change="(page) => fetchPaginado(page)"
      @per-page-change="(perPage) => fetchPaginado(1, perPage)"
    >
      <template #cell-edicao="{ value }">{{ value }}ª</template>

      <template #cell-valor="{ value }">{{ formatCurrency(value) }}</template>

      <template #cell-autores="{ value }">
        <div class="tag-list">
          <span v-for="a in value" :key="a.id" class="tag">{{ a.nome }}</span>
        </div>
      </template>

      <template #cell-assuntos="{ value }">
        <div class="tag-list">
          <span v-for="s in value" :key="s.id" class="tag">{{ s.descricao }}</span>
        </div>
      </template>

      <template #actions="{ row }">
        <button class="dt-btn-action" title="Editar" @click="openEdit(row)">
          <span class="mdi mdi-pencil-outline"></span>
        </button>
        <button class="dt-btn-action dt-btn-action--danger" title="Excluir" @click="askDelete(row.id)">
          <span class="mdi mdi-trash-can-outline"></span>
        </button>
      </template>
    </DataTable>

    <LivroModal
      v-if="showModal"
      :livro="editing"
      :autores="autores"
      :assuntos="assuntos"
      @save="onSave"
      @cancel="showModal = false"
    />
    <ConfirmModal v-if="showConfirm" @confirm="onConfirmDelete" @cancel="showConfirm = false" />
  </div>
</template>
