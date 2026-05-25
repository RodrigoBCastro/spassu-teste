import { ref } from 'vue'
import api from '@/api/assuntos'
import { useNotification } from './useNotification'

export function useAssuntos() {
  const assuntos = ref([])
  const pagination = ref(null)
  const loading = ref(false)
  const { notify } = useNotification()

  async function fetchPaginado(page = 1, perPage = pagination.value?.per_page ?? 15) {
    loading.value = true
    try {
      const res = await api.getPaginado(page, perPage)
      assuntos.value = res.data
      pagination.value = res.meta
    } catch {
      notify('Erro ao carregar assuntos.', 'error')
    } finally {
      loading.value = false
    }
  }

  async function create(payload) {
    const novo = await api.create(payload)
    await fetchPaginado(1)
    notify('Assunto cadastrado com sucesso.')
    return novo
  }

  async function update(id, payload) {
    const atualizado = await api.update(id, payload)
    await fetchPaginado(pagination.value?.current_page ?? 1)
    notify('Assunto atualizado com sucesso.')
    return atualizado
  }

  async function remove(id) {
    await api.remove(id)
    await fetchPaginado(pagination.value?.current_page ?? 1)
    notify('Assunto removido com sucesso.')
  }

  async function fetchTodos() {
    assuntos.value = await api.getTodos()
  }

  return { assuntos, pagination, loading, fetchPaginado, fetchTodos, create, update, remove }
}
