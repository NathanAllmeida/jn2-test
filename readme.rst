#  API - JN2 Teste
## _API de Sistema de controle de clientes_

Este projeto é um desafio técnico
Feito com
- Codeigniter 3
- MY_MODEL 3
- PHP 7.3
- Mysql 5.7
- JWT
- E bastante café

## Recursos
- Autenticação
- Cadastro de Clientes
- Edição de clientes
- Listagem de cliente
- Deletar cliente
- Consultar todos os clientes com um final especifico na placa

## Instalação
Para começar digite no terminal
```sh
docker up --build
```
Dentro da pasta database encontra se a estrutura do banco de dados junto com os dados
```sh
/database/database.sql
```
Caso aja necessidade de alterar o banco de dados ou usuário, as configurações se encontram em:
```sh
/app/application/config/database.php
```
Após rodar o docker, acesse:
```sh
http://localhost:8100
```

## Referência da API

Todos os metódos da API requerem 2 autenticação no header
X-API-KEY e Authorization Bearer
O primeiro foi enviado junto com o email
O segundo é um token que é retornado no metodo abaixo
```sh
[POST] http://localhost:8100/usuarios/autenticacao
```

## Autenticação
Método: **GET**
URL: **http://localhost:8100/usuarios/autenticacao**
Cabeçalho da Requisição:
```sh
    X-API-KEY: #############
```
Corpo da Requisição:
```sh
none
```

## Cadastro de novo cliente
Método: **POST**
URL: **http://localhost:8100/clientes**
Cabeçalho da Requisição:
```sh
    X-API-KEY: #############
    Authorization: Bearer #############
    Content-Type: application/json
    Accept: application/json
```
Corpo da Requisição:
```sh
{
    "name":"Barry Allen",
    "phone":"(31) 90000-0003",
    "cpf":"058.893.730-48",
    "license_plate":"AAA-0003"
}
```

## Edição de um cliente já existente
Método: **PUT**
URL: **http://localhost:8100/clientes/:id**
Cabeçalho da Requisição:
```sh
    X-API-KEY: #############
    Authorization: Bearer #############
    Content-Type: application/json
    Accept: application/json
```
Corpo da Requisição:
```sh
{
    "name":"Clark Kent da Silva",
    "phone":"(31) 90000-0001",
    "cpf":"515.313.040-10",
    "license_plate":"AAA-0002"
}
```

## Consulta de dados de um cliente
Método: **GET**
URL: **http://localhost:8100/clientes/:id**
Cabeçalho da Requisição:
```sh
    X-API-KEY: #############
    Authorization: Bearer #############

```
Corpo da Requisição:
```sh
none
```

## Remoção de um cliente existente
Método: **DELETE**
URL: **http://localhost:8100/clientes/:id**
Cabeçalho da Requisição:
```sh
    X-API-KEY: #############
    Authorization: Bearer #############

```
Corpo da Requisição:
```sh
none
```

## Consulta de todos os clientes cadastrados na base, onde o último número da placa do carro é igual ao informado
Método: **GET**
URL: **http://localhost:8100/consulta/final-placa/:number**
Cabeçalho da Requisição:
```sh
    X-API-KEY: #############
    Authorization: Bearer #############
```
Corpo da Requisição:
```sh
none
```