<!DOCTYPE html>
<html lang="pt-br">

<?php
session_start();
require_once "codes/BancoDados.php";
$conexao = new BancoDados('localhost', 'root', '', 'marketplace');

//Verifica se a sessão está estabelecida
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];     
} else {
    $conexao->erroDisplay('Você não está logado!');
}

// Conexão com o servidor
$nome = $sobrenome = $estado = $cidade = $foto = $p = $produto = $comprados = '';



// Verifica se já tem os dados cadastrados ou precisa cadastrar
$result = $conexao->returnSql("SELECT * FROM usuarios WHERE id = '" . $id . "'");
$vet = $result->fetch_assoc();

//Vê se tem foto cadastrada e pega o diretório dela
if ($vet["foto"] != '') {
    $local = $vet["foto"];
} else {
    $local = '';
}

//vê se tem dados cadastrados
if ($vet["sobrenome"] != '') {
    $nome = $vet["nome"];
    $sobrenome = $vet["sobrenome"];
    $estado = $vet["estado"];
    $cidade = $vet["cidade"];

    $result = $conexao->returnSql("SELECT * FROM produtos WHERE vendedor = '$id'");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {            
            $produto .="<a style='font-size:20px;' href='http://localhost/marketplace/produto.php?id=".$row['id']."' class='text-dark'>".$row['nome']."</a>" . "<br>";
        }
        $produto .= "<button class='my-1 p-1' onclick='novo_produto()'>Adicione um produto</button>";
    } else {
        $produto = "Você não tem produtos à venda <br> <button class='my-1 p-1' onclick='novo_produto()'>Adicione um produto</button>";
    }
   
    $result = $conexao->returnSql("SELECT c.idproduto, p.descricao FROM produtos p JOIN compras c ON p.id = c.idproduto WHERE c.iduser = '$id'");
    if ($result->num_rows > 0){
        while ($linha = $result->fetch_assoc()){
            $comprados .= "<a style='font-size:20px;' href='http://localhost/marketplace/produto.php?id=".$linha['idproduto']."' class='text-dark'>".$linha['descricao']."</a>" . "<br>";
        }       
    }

} else {
    $p = "cadastrado()";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Encerrar Sessão
    if (isset($_POST["sair"])) {
        $_SESSION['id'] = null;
        $p = "window.location.href = 'http://localhost/marketplace/index.php'";
    }

    //Verifica se um produto foi descrito
    if (isset($_POST["descricao"])) {
        $nome = $conexao->validar($_POST["nproduto"]);
        $desc = $conexao->validar($_POST["descricao"]);
        $preco = (float) $conexao->validar($_POST["preco"]);
        $estoque = (int) $conexao->validar($_POST["estoque"]);
    }

    //Verifica se foi enviado algum arquivo no POST
    if (isset($_FILES["foto"]) || isset($_FILES["pfoto"])) {
        if (isset($_FILES["foto"])) {
            $foto = $_FILES["foto"];
            $pasta = "images/users/perfil/";
        } else {
            $foto = $_FILES["pfoto"];
            $pasta = "images/users/produtos/";
        }

        if ($foto["error"]) {
            $conexao->erroDisplay('Erro ao enviar o arquivo!');
        }

        if ($foto["size"] > 2097152) {
            $conexao->erroDisplay('Arquivo máximo de 2Mb, tente novamente');
        }

        $nomeOriginal = $foto["name"];
        $nomeCodificado = uniqid();
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        $path = $pasta . $nomeCodificado . '.' . $extensao;

        if ($extensao != 'jpg' && $extensao != 'png') {
            $conexao->erroDisplay('Arquivo não suportado!');
        }        

        if (move_uploaded_file($foto["tmp_name"], $path)) {
            if (isset($_FILES['foto'])) {
                if ($local != '' && file_exists($local)) {
                    unlink($local);
                }
                $conexao->simpleSql("UPDATE usuarios SET foto ='$path' WHERE id = '$id'");
                $p = "window.location.href = 'http://localhost/marketplace/index.php'";
            } else {                
                $conexao->simpleSql("INSERT INTO produtos (nome, descricao, preco, estoque, foto, vendedor) VALUES ('$nome', '$desc', '$preco', '$estoque', '$path', '$id' )");
                $p = "window.location.href = 'http://localhost/marketplace/index.php'";
            }
        } else {
            $conexao->erroDisplay('Erro ao salvar o arquivo!');
        }
    }
    // Altera dados de usuário
    if (isset($_POST["estado"])) {
        $nome = $conexao->validar($_POST["nome"]);
        $sobrenome = $conexao->validar($_POST["sobrenome"]);
        $estado = $conexao->validar($_POST["estado"]);
        $cidade = $conexao->validar($_POST["cidade"]);

        $conexao->simpleSql("UPDATE usuarios SET nome = '" . $nome . "', sobrenome = '" . $sobrenome . "', estado = '" . $estado . "', cidade = '" . $cidade . "' WHERE id = '" . $id . "' ");
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olá, <?= $vet["user"] ?> !</title>
    <link rel="shortcut icon" href="images/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="estilos/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <menu class="pt-1">
            <p class="p-0 m-0"><a href="index.php" class="text-decoration-none fs-5">MarketPlace</a></p>
            <form action="" method="post">
                <input type="text" name="pesquisa" id="ipesquisa" placeholder="Pesquise">
                <input type="submit" value="Buscar">
            </form>
            <a href="carrinho.php"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
        </menu>
    </header>

    <main>
        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4 text-center text-md-start" id="foto">
                    <img src="<?= $local ?>" alt="" class="align-center" style="width: 200px; height:200px"><br>
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id="infouser">
                    Bem vindo <?php echo " $nome $sobrenome"; ?>, você mora em <?php echo " $cidade $estado"; ?>
                    <br>
                    <button class="mt-3 p-1" onclick="cadastrado()">Alterar Dados</button> <br>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                        <input type="submit" class="p-1 mt-2" value="Sair" name="sair">
                    </form>

                </div>
            </div>
        </div>

        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4">
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id='produtos'>
                    Seus Produtos:<br>
                    <?= $produto ?>
                </div>
            </div>
        </div>

        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4">
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id='produtos'>
                    Compras Feitas:<br>
                    <?=$comprados?>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        <?= $p ?>

        function novo_produto() {
            div = document.getElementById('produtos')
            conteudo = "Seus Produtos: <br><form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' method='post' enctype='multipart/form-data'><label for='nproduto'>Nome do produto:*</label><input type='text' pattern='([A-Z]{1}[a-zçàá-ü]{2,})' title='Somente primeira letra maiúscula mínimo de 3 caracteres' name='nproduto' id='nproduto' minlength='4' maxlength='30' required class='m-1'><br><label for='descricao'>Descrição do produto:*</label><br><textarea name='descricao' id='descricao' minlength='10' maxlength='200' cols='30' rows='5' required class='m-1' style='resize: none;'></textarea><br><label for='preco'>Preço do produto:*</label><input type='number' name='preco' id='preco' step='0.01' required class='m-1'><br><label for='estoque'>Quantidade de produtos:*</label><input type='number' name='estoque' id='estoque' min='1' required class='m-1'><br><label for='pfoto' class='p-1 border border-dark mb-1'>Foto do Produto*</label><input type='file' name='pfoto' id='pfoto' style='display:none;' required><br><input type='submit' value='Publicar Produto' class='my-1 p-1'></form>"
            div.innerHTML = conteudo
        }

        function cadastrado() {
            container = document.getElementById('infouser')
            foto = document.getElementById('foto')
            formulario = "<form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' method='post' autocomplete='on'><label for='inome' class='mb-2' style='margin-right: 41px;'>Nome:*</label><input type='text' name='nome' id='inome' maxlength='20' minlength='4' required><br><label for='isobrenome' class='mb-2' style='margin-right: 1px;'>Sobrenome:*</label><input type='text' name='sobrenome' id='isobrenome' maxlength='20' minlength='4' required><br><label for='iestado' class='mb-2' style='margin-right: 34px;'>Estado:*</label><select name='estado' id='iestado' class='p-1' style='width: 199px;' required><option value='AC'>Acre</option><option value='AL'>Alagoas</option><option value='AP'>Amapá</option><option value='AM'>Amazonas</option><option value='BA'>Bahia</option><option value='CE'>Ceará</option><option value='DF'>Distrito Federal</option><option value='ES'>Espírito Santo</option><option value='GO'>Goiás</option><option value='MA'>Maranhão</option><option value='MT'>Mato Grosso</option><option value='MS'>Mato Grosso do Sul</option><option value='MG'>Minas Gerais</option><option value='PA'>Pará</option><option value='PB'>Paraíba</option><option value='PR'>Paraná</option><option value='PE'>Pernambuco</option><option value='PI'>Piauí</option><option value='RJ'>Rio de Janeiro</option><option value='RN'>Rio Grande do Norte</option><option value='RS'>Rio Grande do Sul</option><option value='RO'>Rondônia</option><option value='RR'>Roraima</option><option value='SC'>Santa Catarina</option><option value='SP'>São Paulo</option><option value='SE'>Sergipe</option><option value='TO'>Tocantins</option></select> <br><label for='icidade' style='margin-right: 33px;'>Cidade:*</label><input type='text' name='cidade' id='icidade' pattern='([A-Z]{1}[a-zçàá-ü]{2,})' title='Somente primeira letra maiúscula mínimo de 3 caracteres' maxlength='20' required><br><input type='submit' value='Enviar' class='mt-2 p-1'></form> <br><form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' method='post'><input type='submit' class='p-1 mt-2' value='Sair' name='sair'></form>"

            botao = "<form action='<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>' enctype='multipart/form-data' method='post'><label for='ifoto' class='border border-dark rounded p-1 mt-1 text-center' style='width: 200px; cursor:pointer;'>Clique e envie a Imagem</label><input type='file' name='foto' id='ifoto' style='display: none;'> <br> <input type='submit' class='border border-dark rounded p-1 mt-1 text-center' value='Salvar Imagem'></form>"

            container.innerHTML = formulario
            foto.innerHTML += botao
        }
    </script>
</body>

</html>