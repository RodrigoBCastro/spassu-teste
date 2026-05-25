import { ref } from 'vue'
import api from '@/api/livros'
import { useNotification } from './useNotification'

export function useLivros() {
  const livros = ref([])
  const pagination = ref(null)
  const loading = ref(false)
  const { notify } = useNotification()

  async function fetchPaginado(page = 1, perPage = pagination.value?.per_page ?? 15) {
    loading.value = true
    try {
      const res = await api.getPaginado(page, perPage)
      livros.value = res.data
      pagination.value = res.meta
    } catch {
      notify('Erro ao carregar livros.', 'error')
    } finally {
      loading.value = false
    }
  }

  async function create(payload) {
    const novo = await api.create(payload)
    await fetchPaginado(1)
    notify('Livro cadastrado com sucesso.')
    return novo
  }

  async function update(id, payload) {
    await api.update(id, payload)
    await fetchPaginado(pagination.value?.current_page ?? 1)
    notify('Livro atualizado com sucesso.')
  }

  async function remove(id) {
    await api.remove(id)
    await fetchPaginado(pagination.value?.current_page ?? 1)
    notify('Livro removido com sucesso.')
  }

    return { livros, pagination, loading, fetchPaginado, create, update, remove }
}
