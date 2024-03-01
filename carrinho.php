<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <link rel="shortcut icon" href="images/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="estilos/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<?php
require_once "codes/BancoDados.php";
$conexao = new BancoDados('localhost', 'root', '', 'marketplace');

session_start();
if (empty($_SESSION['id'])) {
    $conexao->erroDisplay('Usuário não cadastrado!');
}

// 
$dados = $produto = $sair = $enviar = '';
if (empty($idproduto)) {
    $idproduto = array();
}
if (empty($idcarrinho)) {
    $idcarrinho = [];
}
if (empty($estoque)) {
    $estoque = [];
}

// Seleciona os produtos
$result = $conexao->returnSql("SELECT * FROM produtos p JOIN carrinho c ON p.id = c.idproduto WHERE c.iduser = '" . $_SESSION['id'] . "'; ");

if ($result->num_rows > 0) {
    $enviar = " <form action='' method='post'><input type='submit' class='p-1 my-3' value='Finalizar Compra' name='comprou'></form>";
    while ($row = $result->fetch_assoc()) {
        array_push($idproduto, $row['idproduto']);
        array_push($idcarrinho, $row['id']);
        array_push($estoque, $row['estoque']);
        $dados .= "<div class='card col-3 mt-3 p-2 d-block m-auto' style='width: 18rem; height:450px'><img src='" . $row["foto"] . "' class='card-img-top rounded' style='height: 220px' alt='...'><div class='card-body'><h5 class='card-title'>" . $row['nome'] . "</h5><p class='card-text'>" . $row['descricao'] . "</p><p class='card-text'>R$" .  $row['preco'] . "</p><form action='http://localhost/marketplace/carrinho.php?id=" . $row['id'] . "' method='post'><input type='submit' value='Remover do carrinho' class='btn btn-primary'></form></div></div>";
    }

    // Verificar qual a condição de erro que me fez usar isso
    if (isset($_GET['id'])) {
        if ($conexao->simpleSql("DELETE FROM carrinho WHERE id = '" . $_GET['id'] . "'") == true) {
            $sair = "window.location.href='http://localhost/marketplace/carrinho.php'";
        } else {
            $conexao->erroDisplay('Erro ao remover produto do carrinho!');
        }
    }
    if (isset($_POST['comprou'])) {
        $resultado = $conexao->returnSql("SELECT sobrenome FROM usuarios WHERE id = '" . $_SESSION['id'] . "'");
        $user = $resultado->fetch_assoc();

        if (isset($user['sobrenome'])) {
            $dados = '<div class="text-center fs-5"><i class="bi bi-check-circle text-success display-1"></i><br>Compra Realizada!</div>';
            $qprodutos = count($idproduto);
            for ($i = 0; $i < $qprodutos; $i++) {
                $conexao->simpleSql("INSERT INTO compras (iduser, idproduto) VALUES ('" . $_SESSION['id'] . "', '" . $idproduto[$i] . "')");

                $conexao->simpleSql("DELETE FROM carrinho WHERE id = '" . $idcarrinho[$i] . "'");

                $conexao->simpleSql("UPDATE produtos SET estoque = '" . ($estoque[$i] - 1) . "' WHERE id = '" . $idproduto[$i] . "'  ");
            }
        } else {
            $conexao->erroDisplay('Termine o cadastro para realizar uma compra!');
        }
    }
} else {
    $dados = "Nenhum produto adicionado ainda.";
}
?>

<body>
    <header>
        <menu class="pt-1">
            <p class="p-0 m-0"><a href="index.php" class="text-decoration-none fs-5">MarketPlace</a></p>
            <form action="http://localhost/marketplace/pesquisa.php" method="get" autocomplete="on">
                <input type="text" name="produto" id="ipesquisa" placeholder="Pesquise">
                <input type="submit" value="Buscar">
            </form>
            <a href="login.php"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
        </menu>
    </header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md border p-1 text-center ">
                    <?= $dados ?>

                </div>
            </div>
        </div>

        <div class="container">
            <?= $enviar ?>
        </div>

    </main>

    <script>
        <?= $sair ?>
    </script>
</body>

</html>