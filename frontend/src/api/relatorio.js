import http from './http'

export default {
  livrosPorAutor: () => http.get('/relatorio/livros-por-autor').then(response => response.data.data),
}
