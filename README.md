## Legis

#### Requisitos
- Docker
- Docker-compose
- PHP 7.4+
- Composer

#### Passo a passo
1. Copiar o arquivo **.env.example** para o mesmo local com o nome **.env**

2. Copiar o arquivo **docker-compose.yml.example** para o mesmo local com o nome **docker-compose.yml**

3. Atualize as dependências do *PHP* com o comando:
```shell
composer install
```

4. Para baixar as bibliotecas que seram usadas pelas Views:
```shell
npm install
yarn install
```

5. Em caso de sucesso, execute o build das imagens do *Docker* executando o comando:
```shell
docker-compose up
```

**caso queira executar o *container* em segundo plano acrescente o atributo *-d***
```shell
docker-compose up -d
```

**qualquer erro no banco de dados basta removê-lo, após isso execute o build das imagens novamente:**
```shell
docker-compose down -v
```

6. Para gerar a chave de acesso que está no arquivo **.env**:
```shell
./dartisan key:generate
```

7. Executar para migrar o banco Legis:
   1. Migrate geral
      ```shell
         ./dartisan migrate
      ```
   2. Tenants migrate
      ```shell
        ./dartisan tenants:migrate
      ```
   3. Tenants Seed
      ```shell
        ./dartisan tenants:seed
      ```

8. Abrir o Postman:

9. Criar uma request **post** para o endpoint **/api/tenant**. Podem ser utilizados somente os dominios que estão listados no **config/tenancy** dentro do seu projeto, por exemplo:
```shell
'central_domains' => [
    'legis.genesis.tec.br',
    'dev.legis.genesis.tec.br',
    '127.0.0.1',
    '172.17.0.1',
    'localhost',
],
```

10. Após isso, vá em **Auth** da **Request** criada e siga os segintes passos:
    1. Escolha como tipo da autorização **Api Key**
    2. Em **Key** escreva: **X-Authorization**
    3. Volte no **.env** e copie o **LEGIS_KEY**. Obs.: Caso não exista crie uma.
    4. Retorne ao **Postman** e cole no **Value**
    
Agora voltamos ao **Postman** vamos ter uma aplicação parecida com isso `localhost:8080/api/tenant`. Obs.: É importante ter o /api/tenant.

14. Agora vamos ao **body** da request e colocaremos um json parecido com esse:
```shell
{
    "name" : "< nome da tenant >"
}
```
15. Essa execução pode demorar um pouco pois estará criando o banco e executando as seeds.
