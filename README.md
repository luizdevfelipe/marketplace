<h1 align="center">MarketPlace</h1>

<h2 align="center">🔸 <a href='#Sobre'>Sobre</a> 🔸 <a href='#Motivo'>Motivação</a> 🔸 <a href='#Experimente'>Experimente</a></h2>

<h2 id='Sobre' align="center">Um site onde um usúario pode se cadastrar e comprar ou vender produtos 💳</h2>
<p>Aqui é possível cadastrar um novo produto, adicioná-lo ao carrinho e finalizar a comprar (apenas visualmente)</p>

<hr>
<h3>Tecnologias: 📑 HTML 📑 CSS 📑 JavaScript 📑 PHP 📑 MySQL 📑 Docker</h3>

<h3 id='Motivo'>Motivação:</h3>
<p> ▫️ Projeto realizado com o intuito de aprender técnicas de CRUD, utilizando PHP e MySQL</p> 
<p> ▫️ Além da compreensão de como funciona um site com cadastro de usuários e gerenciamento de dados</p> 

<hr>

<h3 id='Experimente'>Teste na sua máquina:</h3>
<p><strong>1º</strong> Faça download do <a href='https://www.docker.com/products/docker-desktop/'>Docker 🐋</a>, pois é ele o responsável por rodar toda a aplicação em um <strong>Container</strong>.</p>
<p><strong>2º</strong> Instale também esse respositório, através do botão <i>Download Zip</i> ou clonando na sua máquina.</p>
<p><strong>3º</strong> Certifique-se que as portas 8001 e 3307 não estão sendo usadas pelo seu computador, caso contrário abra o arquivo <strong>docker-compose.yml</strong> dentro da pasta <strong>marketplace-docker</strong> e altere as portas conforme necessidade.</p>
<p><strong>4º</strong> Para que o Container seja criado, é necessário, através do terminal rodando no diretório da pasta <strong>marketplace-docker</strong>, digitar o comando: <br>
  
```cmd
docker compose up
```
<p><strong>5º</strong> Dentro da pasta <strong>/src/</strong> há um arquivo <strong>.env.exemple</strong> que deve ser renomedo para <strong>.env</strong> dentro dele há configurações básicas para a conexão com o banco de dados que podem ser alteradas conforme suas necessidades.</p>
<p><strong>6º</strong> Deve-se também instalar as dependências que este projeto utiliza para funcionar corretamente, isso é feito através de um comando no terminal que deve ser executado dentro do container principal <strong>MarketPlace</strong>. Para se conseguir executar comandos dentro do container é preciso digitar o seguinte comando no terminal: </p>

```cmd
docker exec -it MarketPlace bash
```
<p>Agora podemos instalar todas as dependências listadas no arquivo <strong>composer.json</strong> através do comando:</p>

```cmd
composer install
```

<p><strong>7º</strong> O último passo de configuração para que o projeto funcione é quanto ao funcionamento do <strong>Banco de Dados</strong>. Para que ele seja criado e configurado corretamente precisa-se entrar no cmd do container MySQL através do comando: </p>

```cmd
docker exec -it MarketPlace-db bash
```

<p>Agora é preciso entrar no banco de dados com as mesmas credenciais especificadas no arquivo <strong>.env</strong> através do comando e da digitação da senha definida tanto no arquivo de ambiente quanto no arquivo <strong>docker-compose.yml</strong></p>

```cmd
mysql -u root -p
```

<p>É possível criar o banco de dados através do comando da linguagem MySQL:</p>

```cmd
CREATE DATABASE marketplace;
```
<p>Para finalizar, basta digitar um comando no terminal do container principal, <i>MarketPlace</i>, que é responsável por criar todas as tabelas com seus respectivos campos, o comando deve ser executado no terminal do container assim como no 6º passo: </p>

```cmd
./vendor/bin/doctrine-migrations migrate 
```
<p><strong>8º</strong> Tudo Certo! Basta acessar <strong>http://localhost:8001/</strong> para que você possa visualizar o projeto em funcionamento.</p>
