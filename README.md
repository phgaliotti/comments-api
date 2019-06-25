# CommentsAPI

Esta aplicação consiste numa API de comentários em postagens. Os endpoints disponibilizados estão no padrão REST orientados a recursos.

## Tecnologias utilizadas:
* Docker
* PHP v7.1
* [Lumen-Laravel Framework](https://lumen.laravel.com).;
* MySQL v5.7

## Dados de acesso para o banco de dados:
```
DB_HOST=mysql (via SGBD a conexão é feita via localhost)
DB_PORT=3306
DB_DATABASE=commentsapi
DB_USERNAME=root
DB_PASSWORD=abc123
```

## Como executar o projeto:
* **Passo 1**: na pasta onde está localizado o arquivo **docker-compose.yml** execute:
```
 docker-compose up -d
```

* **Passo 2**: acessar o container PHP:
```
docker exec -it esapiens-test-php-fpm bash
```

* **Passo 3**: instalar composer:
```
composer install
```

* **Passo 4**: executar migrations para criação das tabelas:
```
php artisan migrate
```

* **Passo 5**: para iniciar o BD com dados nas tabelas  **users** e **posting** execute (ainda dentro do container):
```
php artisan db:seed
```

# Endpoints disponíveis

Para utilizar as rotas da API, **importe o arquivo "comments_api.postman_collection.json"** em seu [Postman](https://www.getpostman.com/);

### Enjoy it :+1:

