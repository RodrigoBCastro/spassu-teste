<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/relatorio'
import { useNotification } from '@/composables/useNotification'

const dados = ref([])
const loading = ref(false)
const { notify } = useNotification()

onMounted(fetchRelatorio)

async function fetchRelatorio() {
  loading.value = true
  try {
    dados.value = await api.livrosPorAutor()
  } catch {
    notify('Erro ao carregar relatório.', 'error')
  } finally {
    loading.value = false
  }
}

function formatCurrency(val) {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(val)
}

function imprimir() {
  window.print()
}
</script>

<template>
  <div class="relatorio-section">
    <div class="section-header no-print">
      <h4>Relatório — Livros por Autor</h4>
      <button class="btn btn-outline-secondary btn-sm" @click="imprimir">🖨 Imprimir</button>
    </div>

    <div v-if="loading" class="loading-state">Carregando relatório...</div>

    <div v-else-if="dados.length === 0" class="empty-state">
      Nenhum dado disponível.
    </div>

    <div v-else>
      <div v-for="grupo in dados" :key="grupo.cod_au" class="mb-4">
        <h5>{{ grupo.autor_nome }}</h5>
        <div class="table-wrapper">
          <table class="table table-sm table-hover mb-0">
            <thead>
              <tr>
                <th>Título</th>
                <th>Editora</th>
                <th>Ed.</th>
                <th>Ano</th>
                <th>Valor</th>
                <th>Assuntos</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="livro in grupo.livros" :key="livro.cod_l">
                <td>{{ livro.titulo }}</td>
                <td>{{ livro.editora }}</td>
                <td>{{ livro.edicao }}ª</td>
                <td>{{ livro.ano_publicacao }}</td>
                <td>{{ formatCurrency(livro.valor) }}</td>
                <td>{{ livro.assuntos }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
