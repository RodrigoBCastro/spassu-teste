<script setup>
import { RouterLink } from 'vue-router'

const cards = [
  { to: '/livros', icon: '📖', title: 'Livros', desc: 'Cadastro e consulta de livros' },
  { to: '/autores', icon: '✍️', title: 'Autores', desc: 'Gerenciar autores' },
  { to: '/assuntos', icon: '🏷️', title: 'Assuntos', desc: 'Gerenciar assuntos' },
  { to: '/relatorio', icon: '📊', title: 'Relatório', desc: 'Livros agrupados por autor' },
]
</script>

<template>
  <div>
    <h2 style="font-size:1.4rem; font-weight:700">Bem-vindo ao Sistema de Cadastro de Livros</h2>
    <p class="text-muted" style="font-size:0.9rem">Selecione um módulo para começar.</p>

    <div class="home-cards">
      <RouterLink v-for="card in cards" :key="card.to" :to="card.to" class="home-card">
        <div class="home-card__icon">{{ card.icon }}</div>
        <div class="home-card__title">{{ card.title }}</div>
        <div class="home-card__desc">{{ card.desc }}</div>
      </RouterLink>
    </div>
  </div>
</template>
