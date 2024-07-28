# Api Doceria

Este desafio é uma API de um estudo de caso para o gerenciamento de pedidos de uma confeitaria, com a API é possível:

* Criar clientes
* Criar pedidos para estes clientes
* Adicionar doces dentro dos pedidos
* [Documentação swagger](https://app.swaggerhub.com/apis-docs/GFUCCI2005/api_doceria/1.0.0)

# Como Iniciar o projeto

* Clonar o repositório
* Instalar dependências
    - `composer install`
* Iniciar o servidor
    - `php artisan serve`
* Criar um banco mysql e rodar migrations
    - `php artisan migrate --seed`

# Autenticação

Para autenticação, basta criar um usuário na rota "/register", e depois usar as credenciais na rota "/login". Com isso a API irá retornar o token para as demais requisições da API passando o Bearer token no header nas outras requisições.

A autenticação foi feito com o sanctum.

# Tests

Para testar a integração basta rodar `php artisan test`. Após rodar os testes os doces vão ser deletados, então é preciso rodar o `php artisan db:seed`, para que tenha os doces que vão ser adicionados na rota "/order"