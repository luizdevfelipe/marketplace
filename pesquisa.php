<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosso Produtos</title>
    <link rel="shortcut icon" href="images/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="estilos/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<?php
require_once 'codes/BancoDados.php';
$conexao = new BancoDados('localhost', 'root', '', 'marketplace');
$resultados = '';

if (isset($_GET['produto']) && $_GET['produto'] != '') {    
    $pesquisa = '%' . $conexao->validar(str_replace(' ','%',$_GET['produto'])) . '%';

    $result = $conexao->returnSql("SELECT * FROM produtos WHERE nome LIKE '$pesquisa'");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resultados .= "<div class='card d-block m-auto mt-3 p-2' style='width: 18rem; height:450px'><img src='" . $row["foto"] . "' class='card-img-top rounded' style='height: 220px' alt='...'><div class='card-body'><h5 class='card-title'>" . $row['nome'] . "</h5><p class='card-text'>" . $row['descricao'] . "</p><p class='card-text'>R$" .  $row['preco'] . "</p><a href='produto.php?id=" . $row['id'] . "' class='btn btn-primary'>Ver Produto</a></div></div>";
        }
    } else {
        $conexao->erroDisplay('Produto não encontrado :(<br>Tente utilizar palavras mais curtas como: pipoca, prato ou panela.');        
    }
} else {
    $conexao->erroDisplay('Não foi possível encontrar seu produto.');    
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
            <a href="carrinho.php"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
        </menu>
    </header>

    <main>
        <div class="container text-center">
            <?= $resultados ?>
        </div>
    </main>

</body>

</html>