<!DOCTYPE html>
<html lang="pt-br">

<?php

$sair = '';
$id = $_GET['id'] ?? -1;

$server = 'localhost';
$user = 'root';
$password = '';
$dbname = 'marketplace';

$conn = new mysqli($server, $user, $password, $dbname);

if ($conn->connect_error) {
    die("<h1><a href='http://localhost/marketplace/'>Erro de conexão</a></h1>");
}

$sql = "SELECT * FROM produtos WHERE id = $id";

try {
    $result = $conn->query($sql);
} catch (mysqli_sql_exception $e) {
    die("<h1><a href='http://localhost/marketplace/'>Erro ao solicitar produto</a></h1>");
}

if ($result->num_rows > 0) {
    $produto = $result->fetch_assoc();
} else {
    die("<h1><a href='http://localhost/marketplace/'>Erro ao solicitar produto</a></h1>");
}

session_start();

if (isset($_SESSION['id'])) {
    if ($_SESSION['id'] == $produto['vendedor']) {
        $dono = "<form action='' method='post'>
        <input type='submit' value='Remover produto do ar' class='p-1' name='remove'></form>";
    } else {
        $dono = "<form action='' method='post'>
        <input type='submit' class='btn btn-success' value='Adicionar ao carrinho' name='comprar'></form>";
    }

    if (isset($_POST['remove'])) {
        if (file_exists($produto['foto'])) {
            unlink($produto['foto']);
        }
        $sql = "DELETE FROM produtos WHERE id = '" . $produto['id'] . "'";   // Pensar em algo em relação a opção de remover produtos que são chaves estrangeira
        $conn->query($sql);
        $sair = "window.location.href = 'http://localhost/marketplace/user/perfil.php'";
    }
    if (isset($_POST['comprar'])) {
        $sql = "INSERT INTO carrinho (iduser, idproduto) VALUES ('".$_SESSION['id']."', '$id')";
        $conn->query($sql);
        $sair = "window.location.href = 'http://localhost/marketplace/user/carrinho.php'";
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
    <link rel="shortcut icon" href="../images/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/produto.css">
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
        <div class="container py-2">
            <div class="row">
                <div class="col-12 col-md-7 text-center ">
                    <img src="<?= $produto['foto'] ?>" alt="produto" class="rounded" width="90%" height="400px">
                </div>
                <div class="col-12 col-md-5 border border-dark rounded">
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
    </script>
</body>

</html>