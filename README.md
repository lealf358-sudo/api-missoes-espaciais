API REST de Missões Espaciais
1. Identificação
Nome: Francisco Bandel Leal
Curso: Técnico em Informática
Unidade Curricular: Desenvolver Serviços Web
2. Descrição do Projeto
Este projeto consiste no desenvolvimento de uma API REST para o gerenciamento de missões espaciais históricas e futuras.
A API permite consultar, cadastrar, atualizar e remover missões espaciais, utilizando PHP, Slim Framework e JSON.
3. Tecnologias Utilizadas
PHP
Slim Framework
Composer
JSON
Postman
GitHub
4. Como Clonar o Projeto
git clone URL_DO_REPOSITORIO
Depois entre na pasta:
cd missoes
5. Como Instalar as Dependências
Execute:
composer install
6. Como Executar o Projeto
Execute o servidor PHP:
php -S localhost:8081 -t public public/index.php
A API estará disponível em:
http://localhost:8081
7. Documentação dos Endpoints
GET /status
Objetivo: Verificar se a API está funcionando.
URL:
GET http://localhost:8081/status
Resposta:
{
    "status": "ok"
}
Status: 200 OK
GET /missoes
Objetivo: Listar todas as missões cadastradas.
URL:
GET http://localhost:8081/missoes
Resposta:
[
    {
        "id": 1,
        "nome": "Apollo 11",
        "ano": 1969,
        "agencia": "NASA",
        "status": "Concluída"
    }
]
Status: 200 OK
GET /missoes/{id}
Objetivo: Buscar uma missão específica pelo seu ID.
Exemplo:
GET http://localhost:8081/missoes/1
Resposta:
{
    "id": 1,
    "nome": "Apollo 11",
    "ano": 1969,
    "agencia": "NASA",
    "status": "Concluída"
}
Status: 200 OK ou 404 Not Found
POST /missoes
Objetivo: Cadastrar uma nova missão.
URL:
POST http://localhost:8081/missoes
Exemplo de requisição:
{
    "nome": "Artemis III",
    "ano": 2027,
    "agencia": "NASA",
    "status": "Planejada"
}
Status: 201 Created
PUT /missoes/{id}
Objetivo: Atualizar uma missão existente.
Exemplo:
PUT http://localhost:8081/missoes/6
Exemplo de requisição:
{
    "nome": "Artemis III",
    "ano": 2027,
    "agencia": "NASA",
    "status": "Em preparação"
}
Status: 200 OK ou 404 Not Found
DELETE /missoes/{id}
Objetivo: Remover uma missão pelo seu ID.
Exemplo:
DELETE http://localhost:8081/missoes/6
Status: 204 No Content ou 404 Not Found
8. Evidências dos Testes
Os testes da API foram realizados utilizando o Postman.
Foram testados os seguintes endpoints:
GET /status
GET /missoes
GET /missoes/{id}
POST /missoes
PUT /missoes/{id}
DELETE /missoes/{id}