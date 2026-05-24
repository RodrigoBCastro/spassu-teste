import { ref } from 'vue'
import api from '@/api/autores'
import { useNotification } from './useNotification'

export function useAutores() {
  const autores = ref([])
  const loading = ref(false)
  const { notify } = useNotification()

  async function fetchAll() {
    loading.value = true
    try {
      autores.value = await api.getAll()
    } catch {
      notify('Erro ao carregar autores.', 'error')
    } finally {
      loading.value = false
    }
  }

  async function create(payload) {
    const novo = await api.create(payload)
    autores.value.push(novo)
    notify('Autor cadastrado com sucesso.')
    return novo
  }

  async function update(id, payload) {
    const atualizado = await api.update(id, payload)
    const idx = autores.value.findIndex(a => a.id === id)
    if (idx !== -1) autores.value[idx] = atualizado
    notify('Autor atualizado com sucesso.')
    return atualizado
  }

  async function remove(id) {
    await api.remove(id)
    autores.value = autores.value.filter(a => a.id !== id)
    notify('Autor removido com sucesso.')
  }

  return { autores, loading, fetchAll, create, update, remove }
}
