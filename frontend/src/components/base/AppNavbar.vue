<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <nav class="app-navbar">
    <RouterLink to="/" class="app-navbar__brand">📚 Cadastro de Livros</RouterLink>
    <ul class="app-navbar__links">
      <li><RouterLink to="/livros">Livros</RouterLink></li>
      <li><RouterLink to="/autores">Autores</RouterLink></li>
      <li><RouterLink to="/assuntos">Assuntos</RouterLink></li>
      <li><RouterLink to="/relatorio">Relatório</RouterLink></li>
    </ul>
  </nav>
</template>
