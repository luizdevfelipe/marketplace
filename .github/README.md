<h1 align="center">MarketPlace</h1>

<h2 align="center">🔸 <a href='#Sobre'>Sobre</a> 🔸 <a href='#Motivo'>Motivação</a> 🔸 <a href='#Experimente'>Experimente</a></h2>

<h2 id='Sobre' align="center">Um site onde um usúario pode se cadastrar e comprar ou vender produtos 💳</h2>
<p>Aqui é possível cadastrar um novo produto, adicioná-lo ao carrinho e finalizar a comprar via Mercado Pago</p>

<hr>
<h3>Tecnologias: 📑 Laravel 📑 Docker 📑 WSL2 📑 CRON 📑 Vite 📑 Bootstrap 📑 Mercado Pago</h3>

<h3 id='Motivo'>Motivação:</h3>
<p> ▫️ Projeto realizado com a finalizade de aprender a estruturar projetos com Laravel </p> 
<p> ▫️ Utilizar o conceito de container disponível através do Laravel Sail</p> 
<p> ▫️ E subsistemas Linux no Windows</p> 

<hr>

<h3 id='Experimente'>Teste na sua máquina:</h3>
<p><strong>1º</strong> Faça download do <a href='https://www.docker.com/products/docker-desktop/'>Docker 🐋</a>, pois é ele o responsável por rodar toda a aplicação em um <strong>Container</strong>.</p>
<p><strong>1º</strong> Faça download do <a href='https://learn.microsoft.com/en-us/windows/wsl/install'>WSL2</a>, porque o projeto será armazenado neste <strong>Subsistema Linux</strong>.</p>

<p><strong>2º</strong> Instale também esse respositório, através do botão <i>Download Zip</i> ou clonando na sua máquina. A pasta do projeto deve ficar dentro do subsistema, para que o projeto rode com maior eficiência através do Docker, 
    o diretório será algo semelhante a este: <strong>\\wsl.localhost\Ubuntu\home\your_user\marketplace</strong>
</p>
<p><strong>3º</strong> Renomeie o arquivo <strong>.env.example</strong> para <strong>.env</strong> e certifique-se que as portas definidas no arquivo não estão sendo usadas pelo seu computador, caso contrário edite-o alterando as portas conforme necessidade. Também é necessário definir uma senha para o banco de dado no parâmetro <strong>DB_PASSWORD</strong></p>

<p><strong>4º</strong> Para que o container seja criado, antes, é necessário, baixar as dependências que não são enviadas para o GitHub com um container temporário através de um terminal WSL rodando no diretório da pasta <strong>luizdevfelipe@PC:~/marketplace$</strong>, digitando o comando:<br>

```cmd
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

<p><strong>5º</strong> Ainda no terminal WSL é preciso iniciar o container da aplicação para que seja possível configurá-la e utilizá-la futuramente, basta digitar:<br>

```cmd
./vendor/bin/sail up -d
```

<p><strong>6º</strong> Com o container da aplicação inicializado é necessário gerar uma chave de criptografia, que será exclusiva e utilizada para criptografar dados como valores de sessões, isso pode ser feito através do comando:<br>

```cmd
./vendor/bin/sail php artisan key:generate
```

<p><strong>7º</strong> Ao usar o comando Sail Up que é responsável por criar um container Docker da aplicação através do serviço Sail implementado pelo Laravel talvez as migrações do banco de dados ocorram imediatamente, entretanto é frequente a necessidade de migrar o banco manualmente. Caso necessário, basta executar o comando abaixo, que também pode ser executado em caso de dúvidas sem problemas:<br>

```cmd
./vendor/bin/sail artisan migrate
```
<p><strong>8º</strong> Agora, já com a estrutura da aplicação pronta é necessário criar um vínculo da pasta que armazena os arquivos enviados por usuários, majoritariamente imagens, com o sistema em geral para que esses possam ser carregados. Isso é feito através de um comando no container da aplicação executado pelo Sail:</p>

```cmd
./vendor/bin/sail artisan storage:link
```

<p><strong>9º</strong> Para finalizar, dois comandos precisam ser executados, um para instalar os pacotos provenientes do <strong>npm</strong> e outro para processar os arquivos estáticos da aplicação utilizando o asset bundle <strong>Vite</strong>:</p>

```cmd
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

<p><strong>10º</strong> Tudo Certo! Basta acessar <strong>http://localhost:8001/</strong> para que você possa visualizar o projeto em funcionamento. Dica! Ao se cadastrar é necessário confirmar o email, no caso dessa aplicação temos que acessar <strong>http://localhost:8025/</strong> pois é onde o serviço de email está hospedado</p>

<p><strong>Em casos de erro 500:</strong> Esse erro está muito relacionado ao arquivo <strong>mysql.sock.lock</strong> presente dentro do volume <strong>marketplace_sail-mysql</strong> que pode ser visto no aplicativo do Docker. Para solucionar o problema basta apagar esse arquivo e reiniciar o container para que um novo arquivo seja criado de maneira adequada. Em casos de dúvidas basta trocar o parâmetro <strong>APP_DEBUG=true</strong> para que mensagens de erros sejam exibidas.</p>

* Laravel Schedule e API do Mercado Pago 
    - Para que a integração com API do mercado pago funcione é necessário preencher a chave <strong>MERCADO_PAGO_TOKEN=</strong> do arquivo .env com uma chave válida criada no site [Mercado Pago Developers](https://www.mercadopago.com.br/developers/pt) seguindo os passos descritos após criar uma conta.
    - Nessa aplicação existem algumas tarefas agendadas através de comandos Artisan que são executados periodicamente pelo serviço Schedule do Laravel, como esse serviço é baseado em CRON, é necessário adicionar o comando a baixo dentro do arquivo <strong>crontab</strong> do seu WSL2 através de:
        - ```cmd
            crontab -e
            ```
        -  ```cmd
             * * * * * cd /home/<user>/marketplace && ./vendor/bin/sail artisan schedule:run >> /dev/null 2>&1
           ```
