# CommentsAPI

Essa aplicação consiste numa API de comentários em postagens. Os endpoints disponibilizados estão no padrão REST orientados a recursos.

## Tecnologias utilizadas:
* Docker;
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
* **Passo 1**
Na pasta onde está localizado o arquivo **docker-compose.yml** execute:
```
 docker-compose up -d
```

* **Passo 2**
Acessar o container PHP:
```
docker exec -it esapiens-test-php-fpm /bin/bash
```
Se não funcionar com o comando acima executar:
```
docker run -it esapiens-test-php-fpm /bin/bash
```

* **Passo 3**
Executar migrations para criação das tabelas:
```
php artisan migrate
```

* **Passo 4**
Para iniciar o BD com dados nas tabelas  **users** e **posting** execute:
```
php artisan db:seed
```



# Endpoints disponiveis

Para utilizar as APIs **importe o arquivo comments_api.postman_collection.json** em seu [Postman](https://www.getpostman.com/);

##Enjoy it  :fa-thumbs-o-up:

