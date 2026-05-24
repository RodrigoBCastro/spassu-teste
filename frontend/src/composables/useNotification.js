import { ref } from 'vue'

const notifications = ref([])

export function useNotification() {
  function notify(message, type = 'success') {
    const id = Date.now()
    notifications.value.push({ id, message, type })
    setTimeout(() => remove(id), 3500)
  }

  function remove(id) {
    notifications.value = notifications.value.filter(n => n.id !== id)
  }

  return { notifications, notify, remove }
}
