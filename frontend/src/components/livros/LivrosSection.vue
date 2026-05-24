<script setup>
import { ref, onMounted } from 'vue'
import { useLivros } from '@/composables/useLivros'
import { useAutores } from '@/composables/useAutores'
import { useAssuntos } from '@/composables/useAssuntos'
import { useNotification } from '@/composables/useNotification'
import LivroModal from './LivroModal.vue'
import ConfirmModal from '@/components/base/ConfirmModal.vue'

const { livros, pagination, loading, fetchAll, create, update, remove } = useLivros()
const { autores, fetchAll: fetchAutores } = useAutores()
const { assuntos, fetchAll: fetchAssuntos } = useAssuntos()
const { notify } = useNotification()

const showModal = ref(false)
const showConfirm = ref(false)
const editing = ref(null)
const deletingId = ref(null)

onMounted(async () => {
  await Promise.all([fetchAll(), fetchAutores(), fetchAssuntos()])
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

async function goToPage(page) {
  await fetchAll(page)
}
</script>

<template>
  <div>
    <div class="section-header">
      <h4>Livros</h4>
      <button class="btn btn-primary btn-sm" title="Adicionar" @click="openCreate"><span class="mdi mdi-plus"></span></button>
    </div>

    <div v-if="loading" class="loading-state">Carregando...</div>

    <div v-else-if="livros.length === 0" class="empty-state">
      Nenhum livro cadastrado.
    </div>

    <template v-else>
      <div class="table-wrapper">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>Título</th>
              <th>Editora</th>
              <th>Ed.</th>
              <th>Ano</th>
              <th>Valor</th>
              <th>Autores</th>
              <th>Assuntos</th>
              <th class="text-end">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="livro in livros" :key="livro.id">
              <td>{{ livro.titulo }}</td>
              <td>{{ livro.editora }}</td>
              <td>{{ livro.edicao }}ª</td>
              <td>{{ livro.ano_publicacao }}</td>
              <td>{{ formatCurrency(livro.valor) }}</td>
              <td>
                <div class="tag-list">
                  <span v-for="a in livro.autores" :key="a.id" class="tag">{{ a.nome }}</span>
                </div>
              </td>
              <td>
                <div class="tag-list">
                  <span v-for="s in livro.assuntos" :key="s.id" class="tag">{{ s.descricao }}</span>
                </div>
              </td>
              <td class="text-end" style="white-space:nowrap">
                <button class="btn-action btn btn-sm btn-outline-secondary me-1" title="Editar" @click="openEdit(livro)">
                  <span class="mdi mdi-pencil-outline"></span>
                </button>
                <button class="btn-action btn btn-sm btn-outline-danger" title="Excluir" @click="askDelete(livro.id)">
                  <span class="mdi mdi-trash-can-outline"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="pagination && pagination.last_page > 1" class="d-flex justify-content-center mt-3 no-print">
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
              <button class="page-link" @click="goToPage(pagination.current_page - 1)">‹</button>
            </li>
            <li
              v-for="p in pagination.last_page"
              :key="p"
              class="page-item"
              :class="{ active: p === pagination.current_page }"
            >
              <button class="page-link" @click="goToPage(p)">{{ p }}</button>
            </li>
            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
              <button class="page-link" @click="goToPage(pagination.current_page + 1)">›</button>
            </li>
          </ul>
        </nav>
      </div>
    </template>

    <LivroModal
      v-if="showModal"
      :livro="editing"
      :autores="autores"
      :assuntos="assuntos"
      @save="onSave"
      @cancel="showModal = false"
    />

    <ConfirmModal v-if="showConfirm" @confirm="onConfirmDelete" @cancel="showConfirm = false"
    />
  </div>
</template>
