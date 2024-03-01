<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once 'codes/BancoDados.php';

$sair = '';
$id = $_GET['id'] ?? -1;

$conexao = new BancoDados('localhost', 'root', '', 'marketplace');

$result = $conexao->returnSql("SELECT * FROM produtos WHERE id = $id");

if ($result->num_rows > 0) {
    $produto = $result->fetch_assoc();
} else {
    $conexao->erroDisplay('Erro ao solicitar produto!');
}

session_start();

if (isset($_SESSION['id'])) {
    if ($_SESSION['id'] == $produto['vendedor']) {
        $dono = "<form action='' method='post'>
        <input type='submit' value='Editar dados do produto' class='p-1' name='edita'></form>";
    } else {
        $dono = "<form action='' method='post'>
        <input type='submit' class='btn btn-success' value='Adicionar ao carrinho' name='comprar'></form>";
    }

    if (isset($_POST['edita'])) {
        $sair = "editaProduto()";
    }

    if (isset($_POST['nproduto'])) {
        if (!empty($_POST['descricao']) && !empty($_POST["preco"]) && !empty($_POST['estoque']) && !empty($id)) {
            $conexao->simpleSql("UPDATE produtos SET nome = '" . $_POST["nproduto"] . "', descricao = '" . $_POST["descricao"] . "', preco ='" . $_POST["preco"] . "', estoque = '" . $_POST['estoque'] . "' WHERE id = '$id' ");
        }


        $sair = "window.location.href = 'http://localhost/marketplace/'";
    }
    if (isset($_POST['comprar'])) {
        if (!empty($id) && isset($_SESSION['id'])) {
            $conexao->simpleSql("INSERT INTO carrinho (iduser, idproduto) VALUES ('" . $_SESSION['id'] . "', '$id')");
            $sair = "window.location.href = 'http://localhost/marketplace/carrinho.php'";
        }
    }
} else {
    $dono = "<form action='' method='post'><input type='submit' class='btn btn-success' value='Adicionar ao carrinho' name='comprar'></form>";
    if (isset($_POST['comprar'])) {
        $sair = "window.location.href = 'http://localhost/marketplace/login.php'";
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produto['nome'] ?? 'Erro' ?></title>
    <link rel="shortcut icon" href="images/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="estilos/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <menu class="pt-1">
            <p class="p-0 m-0"><a href="index.php" class="text-decoration-none fs-5">MarketPlace</a></p>
            <form action="http://localhost/marketplace/pesquisa.php" method="get" autocomplete="on">
                <input type="text" name="produto" id="ipesquisa" placeholder="Pesquise">
                <input type="submit" value="Buscar">
            </form>
            <a href="login.php"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
            <a href="carrinho.php"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
        </menu>
    </header>

    <main>
        <div class="container py-2">
            <div class="row">
                <div class="col-12 col-md-7 text-center ">
                    <img src="<?= $produto['foto'] ?>" alt="produto" class="rounded" width="90%" height="400px">
                </div>
                <div class="col-12 col-md-5 border border-dark rounded" id="edita">
                    <h1 class="display-5 text-center"><?= $produto['nome'] ?></h1>
                    <p class="mt-5 fs-5"><?= $produto['descricao'] ?></p>
                    <p class="mb-0">Produtos Disponíveis: <?= $produto['estoque'] ?></p>
                    <p class="text-success fs-5">R$<?= $produto['preco'] ?></p>

                    <?= $dono ?>
                </div>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script>
        <?= $sair ?>

        function editaProduto() {
            div = document.getElementById('edita')
            form = "<br><form class='border border-success mb-3 m-1 p-2' action='<? echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id ?>' method='post' enctype='multipart/form-data'><label for='nproduto'>Nome do produto:*</label><input type='text' name='nproduto' id='nproduto' minlength='4' maxlength='30' required class='m-1'><br><label for='descricao'>Descrição do produto:*</label><br><textarea name='descricao' id='descricao' minlength='10' maxlength='200' cols='28' rows='5' required class='m-1' style='resize: none;'></textarea><br><label for='preco'>Preço do produto:*</label><input type='number' name='preco' id='preco' step='0.01' required class='m-1'><br><label for='estoque'>Quantidade de produtos:*</label><input type='number' name='estoque' id='estoque' min='1' required class='m-1'><br><input type='submit' value='Alterar Produto' class='my-1 p-1'></form>";

            div.innerHTML += form;

        }
    </script>
</body>

</html>