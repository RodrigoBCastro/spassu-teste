<script setup>
import { useNotification } from '@/composables/useNotification'
const { notifications, remove } = useNotification()
</script>

<template>
  <div class="notification-container">
    <div
      v-for="n in notifications"
      :key="n.id"
      class="notification"
      :class="`notification--${n.type}`"
      @click="remove(n.id)"
    >
      {{ n.message }}
    </div>
  </div>
</template>
