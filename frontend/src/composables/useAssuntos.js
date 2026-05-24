import { ref } from 'vue'
import api from '@/api/assuntos'
import { useNotification } from './useNotification'

export function useAssuntos() {
  const assuntos = ref([])
  const loading = ref(false)
  const { notify } = useNotification()

  async function fetchAll() {
    loading.value = true
    try {
      assuntos.value = await api.getAll()
    } catch {
      notify('Erro ao carregar assuntos.', 'error')
    } finally {
      loading.value = false
    }
  }

  async function create(payload) {
    const novo = await api.create(payload)
    assuntos.value.push(novo)
    notify('Assunto cadastrado com sucesso.')
    return novo
  }

  async function update(id, payload) {
    const atualizado = await api.update(id, payload)
    const idx = assuntos.value.findIndex(a => a.id === id)
    if (idx !== -1) assuntos.value[idx] = atualizado
    notify('Assunto atualizado com sucesso.')
    return atualizado
  }

  async function remove(id) {
    await api.remove(id)
    assuntos.value = assuntos.value.filter(a => a.id !== id)
    notify('Assunto removido com sucesso.')
  }

  return { assuntos, loading, fetchAll, create, update, remove }
}
