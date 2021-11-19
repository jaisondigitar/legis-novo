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
> composer install

4. Para baixar as bibliotecas que seram usadas pelas Views:
> npm install

> yarn install

5. Em caso de sucesso, execute o build das imagens do *Docker* executando o comando:
> docker-compose up

**caso queira executar o *container* em segundo plano acrescente o atributo *-d***
> docker-compose up -d

**qualquer erro no banco de dados basta removê-lo, após isso volte 1 passo:**

> docker-compose down -v

6. Para gerar a chave de acesso que está no arquivo **.env**:
> ./dartisan key:generate

7. Executar para migrar o banco Legis:
> ./dartisan migrate

8. Execute para entrar no Tinker CLI:
> ./dartisan tinker

9. Para criar um banco e migra-lo. Definir um nome dejesado para o cliente:
> $tenant1 = App\Models\Tenant::create(['id' => '< Nome Cliente >']);

10. Para criar um dominio. Definir um nome dejesado para o dominio:
> $tenant1->domains()->create(['domain' => '< Nome Dominio >']);

11. Para sair do Tinker CLI:
> exit

12. Para rodar a seed:

**Para rodar em todas os tenants**
> ./dartisan tenants:seed

**Para rodar em um tenent especifico**
> ./dartisan tenants:seed --tenants= < nome tenant >
