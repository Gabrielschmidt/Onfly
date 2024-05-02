# Onfly
Teste técnico para a empresa Onfly.

## Passo a passo para rodar o projeto
Clone o projeto
```sh
git clone https://github.com/Gabrielschmidt/Onfly.git onfly_test
```
```sh
cd onfly_test/
```


Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize essas variáveis de ambiente no arquivo .env
```dosini
APP_NAME="onfly_test"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_aqui
```

Aqui, recomendo usar a ferramenta mailtrap para testar o envio de email. Se caso tiver outro email configurado para envio externo, basta seguir adicionando as credenciais.
```dosini
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=email_gerado_por_mailtrap
MAIL_PASSWORD=senha_gerada_por_mailtrap
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container
```sh
docker-compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Crie as tabelas no banco de dados
```sh
php artisan migrate
```

Popule as tabelas com alguns valores padrão
```sh
php artisan db:seed --class=TypeUserSeeder
```

## Passo a passo para usar a API

Este projeto se trata de um teste, não é necessário qualquer tipo de login ou autenticação de usuário!

Rotas de usuário:
```sh
    cadastro:
        POST http://localhost:8989/api/user
        body:
        {
            "name": "teste",
            "type_user_id": 1, (1 usuário administrador, 2 usuário comum)
            "email": "teste@gmail.com"    
        }

    update:
        PUT http://localhost:8989/api/user
        body:
        {
            "id": 1,
            "name": "teste",
            "type_user_id": 1 (1 usuário administrador, 2 usuário comum),
            "email": "teste@gmail.com"    
        }

    get:
        GET http://localhost:8989/api/user/{user_id}
        

    delete:
        DELETE http://localhost:8989/api/user/{user_id}
```

Rotas de cartão:
```sh
    cadastro:
        POST http://localhost:8989/api/card
        body:
        {
            "user_id": 5,
            "number": "5551231",
	        "balance": 1000.00    
        }

    get:
        GET http://localhost:8989/api/card/{card_id}
```

Rotas de despesas:
```sh
    cadastro:
        POST http://localhost:8989/api/expense
        body:
        {
            "card_id": "9bf2c75c-076c-4aaa-8c92-00bab502155c",
            "transaction": 30    
        }

    get:
        GET http://localhost:8989/api/expense/{user_id}
```

## Considerações técnicas sobre o projeto
1- Login e autenticação: Não foram implementados pois não foi pedido na descrição, sendo assim, alguns dados de usuário que poderiam ter sido resgatados na sessão, tiveram que ser obtidos através de consultas no BD.

2- Mensagens de erro: As excessões de servidor foram retornadas na Controller. Em um cenário real, eu exibiria para o usuário apenas mensagens de erro que fossem do lado do cliente e criaria um LOG para ter registro das mensagens de servidor, ou usaria uma ferramenta de observabilidade, como DataDog!

3-Validação de campos: não fiz validação de campos porque não estavam explicitos na descrição. Em um cenário real, faria validações de input e output dos dados com DTO.

4- Email: Em um cenário real, usaria um sistema de Fila para lidar com um grande volume de disparo de email, poderia também gravar em cache os email que tiveram falha ao serem enviados para um envio posterior, desta forma, a transação seguiria em frente independente do envio de email funcionar ou não.

5- Documentação: deixei o detalhamento de forma bem simples do uso da API aqui no arquivo read.me, por falta de tempo não foi possível elaborar algo mais detalhado em uma ferramenta apropriada. Costumo usar Swagger para documentações de API. De qualquer forma, deixei uma collection na raiz do projeto (Onfly.postman_collection.json). Irá facilitar o teste!

6-Testes: infelizmente também não consegui realizar os testes de unidade por falta de tempo, mas costumo utilizar nos projetos PHPUnit!