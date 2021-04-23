# Sobre a API:
Transferência de dinheiro: de usuário para usuário e usuário para lojista.

# Como fazer o setup da aplicação:
1 - Clone este repositório

2 – Execute o seguinte comando no path do projeto:
```bash
docker compose up -d
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

3 – Aplicação irá subir na porta 8000
```
Acesse: 127.0.0.1/8000
```

4 – A aplicação subirá um banco mysql e um client adminer
```
Acesse o client: 127.0.0.1/8080
Credenciais: 
Server: mysqlsrv
User: root
Password: MySql2019!
DataBase: testedb
```

5 – No banco terão as seguintes tabelas:
```
users (Com dois usuários cadastrados. Um lojista e um usuário comum)
users_type (Com os tipos de usuários: Lojista e Usuário
balances: (Com o saldo dos usuários/Lojistas)
```

# EndPoint Disponível:

Descrição: Faz transferência para lojistas e usuários.
POST -  /api/transfer/action
Exemplo:
``` bash
curl --location --request POST 'http://localhost:8000/api/transfer' \
--header 'Content-Type: application/json' \
--data-raw '{
    "amount" : 10.00,
    "payer" : 33922288819,
    "payee" : 10702387401
}'
```

```
amount: Valor a ser transferido
payer: Pagador (cpf/cnpj)
payee: Receptor (cpf/cnpj)
```

## Responses:
200
```
{
    "message": "Transfer Success!"
}
```
401
```
{
    "message": "Payer not allowed or payer does not exist"
}
```

401
```
{
    "message": "Payee does not exist"
}
```
401
```
{
    "message": "Not enough balance"
}
```
500
```
{
    "message": "Internal Server error"
}
```