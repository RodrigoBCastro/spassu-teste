import { ref } from 'vue'
import api from '@/api/livros'
import { useNotification } from './useNotification'

export function useLivros() {
  const livros = ref([])
  const pagination = ref(null)
  const loading = ref(false)
  const { notify } = useNotification()

  async function fetchAll(page = 1) {
    loading.value = true
    try {
      const res = await api.getAll(page)
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
    await fetchAll()
    notify('Livro cadastrado com sucesso.')
    return novo
  }

  async function update(id, payload) {
    await api.update(id, payload)
    await fetchAll(pagination.value?.current_page ?? 1)
    notify('Livro atualizado com sucesso.')
  }

  async function remove(id) {
    await api.remove(id)
    await fetchAll(pagination.value?.current_page ?? 1)
    notify('Livro removido com sucesso.')
  }

  return { livros, pagination, loading, fetchAll, create, update, remove }
}
