# Cadastro de Livros — Teste Técnico TJRJ

> **🌐 Demo ao vivo:** [https://spassu-teste-main-jtdkib.laravel.cloud](https://spassu-teste-main-jtdkib.laravel.cloud)

Sistema web para cadastro de livros, autores e assuntos, com relatório agrupado por autor.

**Stack:** Laravel 13 · PostgreSQL 16 · Vue 3 · Docker

---

## Pré-requisitos

- [WSL2](https://learn.microsoft.com/pt-br/windows/wsl/install) (Windows Subsystem for Linux)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) com integração WSL2 habilitada

Nenhuma outra dependência é necessária — PHP, Node e Composer rodam dentro dos containers.

---

## Instalação

Clone o repositório e execute o script de setup dentro do WSL:

```bash
git clone https://github.com/RodrigoBCastro/spassu-teste.git
cd spassu-teste
bash setup.sh
```

O script realiza automaticamente:

1. Instala dependências do backend (Composer) e frontend (NPM)
2. Cria e configura os arquivos `.env`
3. Constrói as imagens Docker
4. Sobe a stack (Laravel, Vue, PostgreSQL, Redis)
5. Aguarda o banco ficar pronto e executa as migrations

---

## Acessos

| Serviço | URL |
|---|---|
| Frontend (Vue) | http://localhost:5173 |
| API (Laravel) | http://localhost:8000 |
| Documentação API (Swagger) | http://localhost:8000/api/documentation |

---

## Dados de exemplo (opcional)

Para popular o banco com dados de demonstração:

```bash
docker compose exec app php artisan db:seed
```

---

## Testes

```bash
docker compose exec app php artisan test
```

---

## Estrutura

```
spassu-teste/
├── backend/      # API Laravel (Controllers, Services, Repositories, DTOs)
├── frontend/     # SPA Vue 3 (Composables, Components, API layer)
├── setup.sh      # Script de instalação completa
└── build.sh      # Script de build para deploy (Laravel Cloud)
```
