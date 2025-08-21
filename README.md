# ✅ Todo List - Aplicação Full-Stack

Este é um projeto de uma aplicação de gerenciamento de tarefas (Todo List) full-stack.  
O **front-end** foi construído com **Vue 3 + Tailwind CSS**, enquanto o **back-end** utiliza o **Laravel** para a API RESTful.

---

## 🚀 Funcionalidades

- ✏️ Criação, edição e exclusão de tarefas.  
- 🔄 Atualização de status da tarefa (*Pendente, Em Progresso, Concluído*).  
- 📄 Visualização de tarefas com paginação.  
- 📱 Layout responsivo (desktop e mobile).  
- 🔐 Autenticação de usuário (Laravel Sanctum).  

---

## 🛠️ Tecnologias Utilizadas

### 🔹 Frontend
- ⚡ **Vue.js 3** – Framework JavaScript.  
- 🧭 **Vue Router** – Gerenciamento de rotas.  
- 🎨 **Tailwind CSS** – Estilização rápida e responsiva.  
- 🌐 **Axios** – Cliente HTTP para comunicação com a API.  

### 🔹 Backend
- 🛠️ **Laravel** – Framework PHP para API RESTful.  
- 🔑 **Laravel Sanctum** – Autenticação via tokens.  
- 🐘 **PHP** >= 8.1  
- 🗄️ **MySQL** – Banco de dados relacional.  

### 🔹 Infraestrutura
- 🐳 **Docker** – Empacotamento e execução da aplicação.  
- ⚙️ **Docker Compose** – Orquestração de múltiplos contêineres.  

---

## ⚙️ Pré-requisitos

Você precisa ter instalado:  

- [Docker](https://docs.docker.com/get-docker/)  
- [Docker Compose](https://docs.docker.com/compose/)  

---

## 💻 Instalação e Execução

### 1. Clonar o Repositório
```bash
git clone https://github.com/seu-usuario/todo-list.git
cd todo_list
```

### 2. Configurar Variáveis de Ambiente
Crie um arquivo `.env` na raiz do projeto (mesma pasta do `docker-compose.yml`):  
```bash
cp .env.example .env
```
Edite as variáveis, principalmente as do banco de dados e do **Laravel Sanctum**.  
O host do banco deve ser o mesmo definido no `docker-compose.yml` (por padrão: `db`).  

### 3. Iniciar os Contêineres
```bash
cd todo_list_backend
docker-compose up -d --build
```

### 4. Rodar as Migrations
```bash
docker-compose exec app php artisan migrate
```

### 5. Rodar o Front-end
```bash
cd todo_list_frontend
npm install
npm run dev
```

### 6. Acessar a Aplicação
- 🌐 Front-end: [http://localhost:5173](http://localhost:5173)  
- 🔗 API: [http://localhost:8000](http://localhost:8000)  

---

## 🗺️ Documentação da API

A aplicação front-end se comunica com os seguintes endpoints:  
> Todos os endpoints, exceto **registro** e **login**, exigem autenticação com **Bearer Token**.

---

### 🔑 Autenticação

#### Registrar Usuário
```http
POST /api/register
```

#### Login
```http
POST /api/login
```

#### Logout
```http
POST /api/logout
```

---

### 📋 Gerenciamento de Tarefas

#### Dados do Usuário Autenticado
```http
GET /api/user
```

#### Listar Tarefas
```http
GET /api/tasks
```

#### Criar Tarefa
```http
POST /api/tasks
```

#### Buscar Tarefa
```http
GET /api/tasks/{id}
```

#### Atualizar Tarefa
```http
PATCH /api/tasks/{id}
```

#### Deletar Tarefa
```http
DELETE /api/tasks/{id}
```

---

### Testes Automatizados
```
docker-compose exec app sh

./vendor/bin/pest
```