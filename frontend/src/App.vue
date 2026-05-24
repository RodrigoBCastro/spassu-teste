<script setup>
import { RouterView } from 'vue-router'
import AppNavbar from '@/components/base/AppNavbar.vue'
import AppNotification from '@/components/base/AppNotification.vue'
</script>

<template>
  <div class="app-wrapper">
    <AppNavbar />
    <main class="app-content">
      <RouterView />
    </main>
    <AppNotification />
  </div>
</template>
