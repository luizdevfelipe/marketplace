<!DOCTYPE html>
<html lang="pt-br">

<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("<h1><a href='http://localhost/marketplace/login.php'>Usuário não cadastrado</a></h1>");
}

// Conexão com o servidor
$dados = $produto = $sair = $enviar = '';
if (!isset($idproduto)) {
    $idproduto = array();
}
if(!isset($idcarrinho)){
    $idcarrinho = [];
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'marketplace';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<h1><a href='http://localhost/marketplace/'>Erro de conexão</a></h1>");
}

// Seleciona os produtos
$sql = "SELECT * FROM produtos p JOIN carrinho c ON p.id = c.idproduto WHERE c.iduser = '" . $_SESSION['id'] . "'; ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $enviar = " <form action='' method='post'><input type='submit' class='p-1 my-3' value='Finalizar Compra' name='comprou'></form>";
    while ($row = $result->fetch_assoc()) {
        array_push($idproduto, $row['idproduto']);
        array_push($idcarrinho, $row['id']);
        $dados .= "<div class='card col-3 mt-3 p-2 d-block m-auto' style='width: 18rem; height:450px'><img src='" . $row["foto"] . "' class='card-img-top rounded' style='height: 220px' alt='...'><div class='card-body'><h5 class='card-title'>" . $row['nome'] . "</h5><p class='card-text'>" . $row['descricao'] . "</p><p class='card-text'>R$" .  $row['preco'] . "</p><form action='http://localhost/marketplace/user/carrinho.php?id=" . $row['id'] . "' method='post'><input type='submit' value='Remover do carrinho' class='btn btn-primary'></form></div></div>";
    }

    if (isset($_GET['id'])) {
        $sql = "DELETE FROM carrinho WHERE id = '" . $_GET['id'] . "'";
        if ($conn->query($sql) === TRUE) {
            $sair = "window.location.href='http://localhost/marketplace/user/carrinho.php'";
        } else {
            die("<h1><a href='http://localhost/marketplace/user/carrinho.php'>Erro ao remover produto</a></h1>");
        }
    }
    if (isset($_POST['comprou'])) {
        $sql = "SELECT sobrenome FROM usuarios WHERE id = '" . $_SESSION['id'] . "'";
        try {
            $resultado = $conn->query($sql);
            $sobrenome = $resultado->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            die("<h1><a href='http://localhost/marketplace/'>Erro ao solicitar dados de usuário</a></h1>");
        }
        if (isset($sobrenome['sobrenome'])) {
            $dados = '<div class="text-center fs-5"><i class="bi bi-check-circle text-success display-1"></i><br>Compra Realizada!</div>';
            for ($i = 0; $i < count($idproduto); $i++) {
                $sql = "INSERT INTO compras (iduser, idproduto) VALUES ('" . $_SESSION['id'] . "', '".$idproduto[$i]."')";
                try {
                    $query = $conn->query($sql);
                } catch (mysqli_sql_exception $e) {
                    die("<h1><a href='http://localhost/marketplace/'>Erro ao fazer a solicitação de compra</a></h1>");
                }
                $sql = "DELETE FROM carrinho WHERE id = '".$idcarrinho[$i]."'  ";
                try {
                    $query = $conn->query($sql);
                } catch (mysqli_sql_exception $e) {
                    die("<h1><a href='http://localhost/marketplace/'>Erro ao fazer a solicitação de compra</a></h1>");
                }
            }
        } else {
            die("<h1><a href='http://localhost/marketplace/user/perfil.php'>Termine o cadastro para realizar uma compra</a></h1>");
        }
    }
} else {
    $dados = "Nenhum produto adicionado ainda.";
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <link rel="shortcut icon" href="../images/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <menu class="pt-1">
            <p class="p-0 m-0"><a href="../index.php" class="text-decoration-none fs-5">MarketPlace</a></p>
            <form action="" method="post">
                <input type="text" name="pesquisa" id="ipesquisa" placeholder="Pesquise">
                <input type="submit" value="Buscar">
            </form>
            <a href="../login.php"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
            <a href="carrinho.php"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
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