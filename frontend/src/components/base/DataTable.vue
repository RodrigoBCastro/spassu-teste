<script setup>
import { computed, useSlots } from 'vue'

const props = defineProps({
  columns: { type: Array, required: true },
  rows: { type: Array, default: () => [] },
  pagination: { type: Object, default: null },
  loading: { type: Boolean, default: false },
  emptyMessage: { type: String, default: 'Nenhum registro encontrado.' },
  perPageOptions: { type: Array, default: () => [15, 25, 50] },
})

const emit = defineEmits(['page-change', 'per-page-change'])
const slots = useSlots()

const hasActions = computed(() => !!slots.actions)

const infoText = computed(() => {
  if (!props.pagination) return ''
  const { from, to, total } = props.pagination
  if (!from) return `0 de ${total} registros`
  return `Mostrando ${from}–${to} de ${total} registros`
})

const visiblePages = computed(() => {
  if (!props.pagination) return []
  const { current_page: cur, last_page: last } = props.pagination
  if (last <= 7) return Array.from({ length: last }, (_, i) => i + 1)

  const set = new Set([1, last])
  for (let p = Math.max(2, cur - 1); p <= Math.min(last - 1, cur + 1); p++) set.add(p)

  const sorted = [...set].sort((a, b) => a - b)
  const result = []
  for (let i = 0; i < sorted.length; i++) {
    if (i > 0 && sorted[i] - sorted[i - 1] > 1) result.push('...')
    result.push(sorted[i])
  }
  return result
})

function goTo(page) {
  if (!props.pagination) return
  const { current_page, last_page } = props.pagination
  if (page < 1 || page > last_page || page === current_page) return
  emit('page-change', page)
}

function onPerPage(e) {
  emit('per-page-change', Number(e.target.value))
}
</script>

<template>
  <div class="dt-root">
    <div v-if="loading" class="loading-state">Carregando...</div>

    <template v-else>
      <div v-if="rows.length === 0" class="empty-state">{{ emptyMessage }}</div>

      <template v-else>
        <div class="table-wrapper">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th v-for="col in columns" :key="col.key" :style="col.width ? { width: col.width } : {}">
                  {{ col.label }}
                </th>
                <th v-if="hasActions" class="dt-actions-th"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in rows" :key="row.id">
                <td
                  v-for="col in columns"
                  :key="col.key"
                  :class="col.class"
                  :style="col.width ? { width: col.width } : {}"
                >
                  <slot :name="`cell-${col.key}`" :row="row" :value="row[col.key]">
                    {{ row[col.key] }}
                  </slot>
                </td>
                <td v-if="hasActions" class="dt-actions-td">
                  <slot name="actions" :row="row" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-if="pagination" class="dt-footer no-print">
          <span class="dt-info">{{ infoText }}</span>

          <div class="dt-controls">
            <div class="dt-per-page">
              <label class="dt-per-page__label">Linhas por página</label>
              <select class="dt-per-page__select" :value="pagination.per_page" @change="onPerPage">
                <option v-for="n in perPageOptions" :key="n" :value="n">{{ n }}</option>
              </select>
            </div>

            <nav class="dt-pagination">
              <button class="dt-page-btn" :disabled="pagination.current_page === 1" @click="goTo(1)" title="Primeira">«</button>
              <button class="dt-page-btn" :disabled="pagination.current_page === 1" @click="goTo(pagination.current_page - 1)" title="Anterior">‹</button>

              <template v-for="p in visiblePages" :key="p">
                <span v-if="p === '...'" class="dt-ellipsis">…</span>
                <button
                  v-else
                  class="dt-page-btn"
                  :class="{ 'dt-page-btn--active': p === pagination.current_page }"
                  @click="goTo(p)"
                >{{ p }}</button>
              </template>

              <button class="dt-page-btn" :disabled="pagination.current_page === pagination.last_page" @click="goTo(pagination.current_page + 1)" title="Próxima">›</button>
              <button class="dt-page-btn" :disabled="pagination.current_page === pagination.last_page" @click="goTo(pagination.last_page)" title="Última">»</button>
            </nav>
          </div>
        </div>
      </template>
    </template>
  </div>
</template>

<style scoped>
.dt-root {
  display: flex;
  flex-direction: column;
  gap: 0;
}

/* Footer */
.dt-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.65rem 1rem;
  background-color: var(--color-surface);
  border: 1px solid var(--color-border);
  border-top: none;
  border-radius: 0 0 var(--radius) var(--radius);
  font-size: 0.82rem;
  color: var(--color-text-muted);
  gap: 1rem;
  flex-wrap: wrap;
}

.dt-info {
  white-space: nowrap;
}

.dt-controls {
  display: flex;
  align-items: center;
  gap: 1.25rem;
}

/* Per page */
.dt-per-page {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.dt-per-page__label {
  white-space: nowrap;
  font-size: 0.82rem;
  color: var(--color-text-muted);
}

.dt-per-page__select {
  background-color: var(--color-surface-hover);
  color: var(--color-text);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-sm);
  padding: 0.2rem 0.5rem;
  font-size: 0.82rem;
  cursor: pointer;
  outline: none;
}

.dt-per-page__select:focus {
  border-color: var(--color-primary);
}

/* Pagination */
.dt-pagination {
  display: flex;
  align-items: center;
  gap: 0.2rem;
}

.dt-page-btn {
  min-width: 30px;
  height: 30px;
  padding: 0 0.4rem;
  background-color: var(--color-surface-hover);
  color: var(--color-text-muted);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-sm);
  font-size: 0.82rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color var(--transition), color var(--transition), border-color var(--transition);
  line-height: 1;
}

.dt-page-btn:hover:not(:disabled) {
  background-color: var(--color-primary);
  border-color: var(--color-primary);
  color: #fff;
}

.dt-page-btn--active {
  background-color: var(--color-primary) !important;
  border-color: var(--color-primary) !important;
  color: #fff !important;
}

.dt-page-btn:disabled {
  opacity: 0.35;
  cursor: not-allowed;
}

.dt-ellipsis {
  padding: 0 0.25rem;
  color: var(--color-text-muted);
  font-size: 0.82rem;
  user-select: none;
}

/* Actions column */
.dt-actions-th {
  width: 1px;
  white-space: nowrap;
}

.dt-actions-td {
  white-space: nowrap;
  text-align: right;
}
</style>
