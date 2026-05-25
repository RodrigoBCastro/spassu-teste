import { ref } from 'vue'
import api from '@/api/autores'
import { useNotification } from './useNotification'

export function useAutores() {
  const autores = ref([])
  const pagination = ref(null)
  const loading = ref(false)
  const { notify } = useNotification()

  async function fetchPaginado(page = 1, perPage = pagination.value?.per_page ?? 15) {
    loading.value = true
    try {
      const res = await api.getPaginado(page, perPage)
      autores.value = res.data
      pagination.value = res.meta
    } catch {
      notify('Erro ao carregar autores.', 'error')
    } finally {
      loading.value = false
    }
  }

  async function create(payload) {
    const novo = await api.create(payload)
    await fetchPaginado(1)
    notify('Autor cadastrado com sucesso.')
    return novo
  }

  async function update(id, payload) {
    const atualizado = await api.update(id, payload)
    await fetchPaginado(pagination.value?.current_page ?? 1)
    notify('Autor atualizado com sucesso.')
    return atualizado
  }

  async function remove(id) {
    await api.remove(id)
    await fetchPaginado(pagination.value?.current_page ?? 1)
    notify('Autor removido com sucesso.')
  }

  async function fetchTodos() {
    autores.value = await api.getTodos()
  }

  return { autores, pagination, loading, fetchPaginado, fetchTodos, create, update, remove }
}
