## Legis

#### Requirements
- Docker
- Docker-compose
- PHP 5.5+
- Composer

#### Step by step
1.Atualize as dependências do *PHP* com o comando:
> composer install

2.Copiar o arquivo *docker-compose.yml.example* para o mesmo local com o nome *docker-compose.yml*

3.Em caso de sucesso, execute o build das imagens do *Docker* executando o comando:
> docker-compose up

**caso queira executar o *container* em segundo plano acrescente o atributo *-d***
> docker-compose up -d

**qualquer erro no banco de dados basta removê-lo com para criar novamente executando o comando:**

> docker volume rm legis-db && docker-compose up

4.Copiar o arquivo *.env.example* para o mesmo local com o nome *.env*

5.Configure os acessos ao banco de dados nas variáveis *DB_USERNAME* e *DB_PASSWORD* no arquivo 
*.env*

6.Gerar a *APP_KEY* com o comando:
> dartisan key:generate

7.Gerar as tabelas e alimentá-las:
> dartisan migrate ou dartisan migrate --seed

**Testes existentes com falha!**
