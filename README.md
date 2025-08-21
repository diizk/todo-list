### Todo List - Aplicação Full-Stack

- Este é um projeto de uma aplicação de gerenciamento de tarefas (Todo List) full-stack. O front-end foi construído com Vue 3 e Tailwind CSS, enquanto o back-end utiliza o framework Laravel para a API RESTful.

### 🚀 Funcionalidades

    Criação, edição e exclusão de tarefas.

    Atualização de status da tarefa (Pendente, Em Progresso, Concluído).

    Visualização de tarefas com paginação.

    Layout responsivo para desktop e dispositivos móveis.

    Sistema de autenticação de usuário (com Laravel Sanctum).

### 🛠️ Tecnologias Utilizadas

- Frontend

    Vue.js 3: Framework JavaScript para a interface do usuário.

    Vue Router: Gerenciamento de rotas.

    Tailwind CSS: Framework utilitário de CSS para estilização rápida e responsiva.

    Axios: Cliente HTTP para comunicação com a API.

- Backend

    Laravel Framework: Framework PHP para a API RESTful.

    Laravel Sanctum: Autenticação via tokens.

    PHP: Linguagem de programação do servidor (versão recomendada: >= 8.1).

    MySQL: Banco de dados relacional.

- Infraestrutura

    Docker: Plataforma para empacotar e executar a aplicação.

    Docker Compose: Ferramenta para gerenciar a execução de múltiplos contêineres.

### ⚙️ Pré-requisitos

- Para rodar o projeto na sua máquina, você precisa ter apenas o Docker e o Docker Compose instalados.

### 💻 Instalação e Execução

- Siga os passos abaixo para subir a aplicação. O Docker Compose cuidará de toda a configuração do ambiente, incluindo a instalação de dependências.

1. Clonar o Repositório

2. Configurar Variáveis de Ambiente

Crie um arquivo .env na raiz do projeto (na mesma pasta do docker-compose.yml) copiando o arquivo de exemplo.

Abra o arquivo .env e configure as variáveis de ambiente, principalmente a do banco de dados e a do Laravel Sanctum. O nome do host do banco de dados deve ser o mesmo do serviço no docker-compose.yml (por padrão, db).

3. Iniciar os Contêineres

Execute o seguinte comando para construir as imagens e iniciar todos os contêineres em segundo plano (docker compose up -d --build).

4. Rodar as Migrations

Com os contêineres rodando, você precisa executar as migrações para criar as tabelas no banco de dados. Use o comando docker-compose exec app php artisan migrate para rodar comandos dentro do contêiner da aplicação.


5. Acessar a Aplicação

O front-end estará disponível em http://localhost:5173 e a API do back-end em http://localhost:8000.