### Todo List - Aplicação Full-Stack

Este é um projeto de uma aplicação de gerenciamento de tarefas (Todo List) full-stack. O front-end foi construído com Vue 3 e Tailwind CSS, enquanto o back-end utiliza o framework Laravel para a API RESTful.

### 🚀 Funcionalidades

    Criação, edição e exclusão de tarefas.

    Atualização de status da tarefa (Pendente, Em Progresso, Concluído).

    Visualização de tarefas com paginação.

    Layout responsivo para desktop e dispositivos móveis.

    Sistema de autenticação de usuário (com Laravel Sanctum).

### 🛠️ Tecnologias Utilizadas

Frontend

    Vue.js 3: Framework JavaScript para a interface do usuário.

    Vue Router: Gerenciamento de rotas.

    Tailwind CSS: Framework utilitário de CSS para estilização rápida e responsiva.

    Axios: Cliente HTTP para comunicação com a API.

Backend

    Laravel Framework: Framework PHP para a API RESTful.

    Laravel Sanctum: Autenticação via tokens.

    PHP: Linguagem de programação do servidor (versão recomendada: >= 8.1).

    MySQL: Banco de dados relacional.

Infraestrutura

    Docker: Plataforma para empacotar e executar a aplicação.

    Docker Compose: Ferramenta para gerenciar a execução de múltiplos contêineres.

### ⚙️ Pré-requisitos

Para rodar o projeto na sua máquina, você precisa ter apenas o Docker e o Docker Compose instalados.

### 💻 Instalação e Execução

Siga os passos abaixo para subir a aplicação. O Docker Compose cuidará de toda a configuração do ambiente, incluindo a instalação de dependências.

1. Clonar o Repositório

2. Configurar Variáveis de Ambiente

Crie um arquivo .env na raiz do projeto (na mesma pasta do docker-compose.yml) copiando o arquivo de exemplo.

Abra o arquivo .env e configure as variáveis de ambiente, principalmente a do banco de dados e a do Laravel Sanctum. O nome do host do banco de dados deve ser o mesmo do serviço no docker-compose.yml (por padrão, db).

3. Iniciar os Contêineres

Execute o seguinte comando para construir as imagens e iniciar todos os contêineres em segundo plano ('docker compose up -d --build').

4. Rodar as Migrations

Com os contêineres rodando, você precisa executar as migrações para criar as tabelas no banco de dados. Use o comando docker-compose exec app php artisan migrate para rodar comandos dentro do contêiner da aplicação.

5. Rodar o front-end

Execute o comando npm install para instalar as dependências do front-end e depois npm run dev para rodar o projeto.

6. Acessar a Aplicação

O front-end estará disponível em http://localhost:5173 e a API do back-end em http://localhost:8000.

### 🗺️ Documentação da API

A aplicação front-end se comunica com os seguintes endpoints da API RESTful. Todos os endpoints, exceto o de registro e login, exigem autenticação com um Bearer Token.

Autenticação

POST /api/register

    Descrição: Registra um novo usuário.

    Corpo da Requisição (JSON):

    Resposta de Sucesso (201 Created):

POST /api/login

    Descrição: Autentica um usuário existente.

    Corpo da Requisição (JSON):

    Resposta de Sucesso (200 OK):

POST /api/logout

    Descrição: Invalida o token de autenticação do usuário.

    Autenticação: Sim (Bearer Token)

    Resposta de Sucesso (200 OK):

Gerenciamento de Tarefas

GET /api/user

    Descrição: Retorna os dados do usuário autenticado.

    Autenticação: Sim (Bearer Token)

    Resposta de Sucesso (200 OK):

GET /api/tasks

    Descrição: Lista todas as tarefas do usuário autenticado com paginação.

    Autenticação: Sim (Bearer Token)

    Resposta de Sucesso (200 OK):

POST /api/tasks

    Descrição: Cria uma nova tarefa para o usuário autenticado.

    Autenticação: Sim (Bearer Token)

    Corpo da Requisição (JSON):

    Resposta de Sucesso (201 Created):

GET /api/tasks/{id}

    Descrição: Retorna uma tarefa específica.

    Autenticação: Sim (Bearer Token)

    Resposta de Sucesso (200 OK):

PATCH /api/tasks/{id}

    Descrição: Atualiza uma tarefa existente.

    Autenticação: Sim (Bearer Token)

    Corpo da Requisição (JSON):

    Resposta de Sucesso (200 OK):

DELETE /api/tasks/{id}

    Descrição: Deleta uma tarefa.

    Autenticação: Sim (Bearer Token)

    Resposta de Sucesso (204 No Content): (Resposta sem corpo, indicando sucesso na exclusão).
