<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olá, <?= $user[0]["user"] ?> !</title>
    <link rel="shortcut icon" href="storage/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="storage/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
<header>
    <menu class="pt-1">
      <p class="p-0 m-0"><a href="/" class="text-decoration-none fs-5">MarketPlace</a></p>
      <form action="/pesquisa" method="get" autocomplete="on">
        <input type="text" name="produto" id="ipesquisa" placeholder="Pesquise" required>
        <input type="submit" value="Buscar">
      </form>      
      <a href="/carrinho"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
    </menu>
  </header>

    <main>
        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4 text-center text-md-start" id="foto">
                    <img src="<?= $local ?>" alt="" class="align-center" style="width: 200px; height:200px"><br>
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id="infouser">
                    <?php if(isset($user[0]['sobrenome'])): ?>
                    Bem vindo <?= $user[0]['nome'] . ' ' . $user[0]['sobrenome'] ?>, você mora em <?= $user[0]['cidade'] . ' ' . $user[0]['estado'] ?>
                    <br>
                    <button class="mt-3 p-1" onclick="cadastrado()">Alterar Dados</button> <br>

                    <form action="<?= htmlspecialchars('/sair') ?>" method="post">
                        <input type="submit" class="p-1 mt-2" value="Sair" name="sair">
                    </form>

                    <?php else: ?>
                        <button class="btn btn-success" onclick="cadastrado()">Terminar cadastro</button>
                    <?php endif; ?>

                </div>
            </div>
        </div>
 
        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4">
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id='produtos'>
                    Seus Produtos:<br>
                    <!-- Para produtos cadastrados -->
                    <?php if (!empty($products)) : ?>

                        <?php foreach($products as $row): ?>
                        <a style='font-size:20px;' href='/produto?id=<?=$row["id"]?>' class='text-dark'> <?=$row["nome"]?> </a> . <br>                  
                        <?php endforeach; ?>
                        <button class='my-1 p-1' onclick='novo_produto()'>Adicione um produto</button>

                    <?php else: ?>
                        <!-- // Se não tiver produtos -->
                        Você não tem produtos à venda <br> <button class='my-1 p-1' onclick='novo_produto()'>Adicione um produto</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4">
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id='produtos'>
                    Compras Feitas:<br>
                    <?php if(!empty($purchases)): ?>
                        <?php foreach($purchases as $row): ?>
                            <a style='font-size:20px;' href="/produto?id=<?=$row['idproduto']?>" class='text-dark'> <?=$row['nome'] ?></a> <br>
                        <?php endforeach; ?>
                    <?php endif; ?>                    
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>

        function novo_produto() {
            div = document.getElementById('produtos')
            conteudo = "Seus Produtos: <br><form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' method='post' enctype='multipart/form-data'><label for='nproduto'>Nome do produto:*</label><input type='text' pattern='([A-Z]{1}[a-zçàá-ü]{2,})' title='Somente primeira letra maiúscula mínimo de 3 caracteres' name='nproduto' id='nproduto' minlength='4' maxlength='30' required class='m-1'><br><label for='descricao'>Descrição do produto:*</label><br><textarea name='descricao' id='descricao' minlength='10' maxlength='200' cols='30' rows='5' required class='m-1' style='resize: none;'></textarea><br><label for='preco'>Preço do produto:*</label><input type='number' name='preco' id='preco' step='0.01' required class='m-1'><br><label for='estoque'>Quantidade de produtos:*</label><input type='number' name='estoque' id='estoque' min='1' required class='m-1'><br><label for='pfoto' class='p-1 border border-dark mb-1'>Foto do Produto*</label><input type='file' name='pfoto' id='pfoto' style='display:none;' required><br><input type='submit' value='Publicar Produto' class='my-1 p-1'></form>"
            div.innerHTML = conteudo
        }

        function cadastrado() {
            container = document.getElementById('infouser')
            foto = document.getElementById('foto')
            formulario = "<form action='<?= htmlspecialchars('/novocad') ?>' method='post' autocomplete='on'><label for='inome' class='mb-2' style='margin-right: 41px;'>Nome:*</label><input type='text' name='nome' id='inome' maxlength='20' minlength='4' required><br><label for='isobrenome' class='mb-2' style='margin-right: 1px;'>Sobrenome:*</label><input type='text' name='sobrenome' id='isobrenome' maxlength='20' minlength='4' required><br><label for='iestado' class='mb-2' style='margin-right: 34px;'>Estado:*</label><select name='estado' id='iestado' class='p-1' style='width: 199px;' required><option value='AC'>Acre</option><option value='AL'>Alagoas</option><option value='AP'>Amapá</option><option value='AM'>Amazonas</option><option value='BA'>Bahia</option><option value='CE'>Ceará</option><option value='DF'>Distrito Federal</option><option value='ES'>Espírito Santo</option><option value='GO'>Goiás</option><option value='MA'>Maranhão</option><option value='MT'>Mato Grosso</option><option value='MS'>Mato Grosso do Sul</option><option value='MG'>Minas Gerais</option><option value='PA'>Pará</option><option value='PB'>Paraíba</option><option value='PR'>Paraná</option><option value='PE'>Pernambuco</option><option value='PI'>Piauí</option><option value='RJ'>Rio de Janeiro</option><option value='RN'>Rio Grande do Norte</option><option value='RS'>Rio Grande do Sul</option><option value='RO'>Rondônia</option><option value='RR'>Roraima</option><option value='SC'>Santa Catarina</option><option value='SP'>São Paulo</option><option value='SE'>Sergipe</option><option value='TO'>Tocantins</option></select> <br><label for='icidade' style='margin-right: 33px;'>Cidade:*</label><input type='text' name='cidade' id='icidade' title='Somente primeira letra maiúscula mínimo de 3 caracteres' maxlength='20' required><br><input type='submit' value='Enviar' class='mt-2 p-1'></form> <br><form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' method='post'><input type='submit' class='p-1 mt-2' value='Sair' name='sair'></form>"

            botao = "<form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' enctype='multipart/form-data' method='post'><label for='ifoto' class='border border-dark rounded p-1 mt-1 text-center' style='width: 200px; cursor:pointer;'>Clique e envie a Imagem</label><input type='file' name='foto' id='ifoto' style='display: none;'> <br> <input type='submit' class='border border-dark rounded p-1 mt-1 text-center' value='Salvar Imagem'></form>"

            container.innerHTML = formulario
            foto.innerHTML += botao
        }
    </script>
</body>

</html>