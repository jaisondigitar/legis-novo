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
```shell
./dartisan migrate
```

8. Execute para entrar no Tinker CLI:
```shell
./dartisan tinker
```

9. Para criar um banco e migra-lo. Definir um nome dejesado para o cliente:
```shell
$tenant1 = App\Models\Tenant::create(['id' => '< Nome Cliente >']);
```

10. Para criar um dominio. Definir um nome dejesado para o dominio:
```shell
$tenant1->domains()->create(['domain' => '< Nome Dominio >']);
```

11. Para sair do Tinker CLI:
```shell
exit
```

12. Para rodar a seed:

**Para rodar em todas os tenants**
```shell
./dartisan tenants:seed
```

**Para rodar em um tenent especifico**
```shell
./dartisan tenants:seed --tenants= < nome tenant >
```
