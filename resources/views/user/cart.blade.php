<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Página de Login</title>
    <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="resources/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<?php
if (empty($idproduto)) {
    $idproduto = [];
}
if (empty($idcarrinho)) {
    $idcarrinho = [];
}
if (empty($estoque)) {
    $estoque = [];
}
?>

<body>
    <header>
        <menu class="pt-1">
            <p class="p-0 m-0"><a href="/" class="text-decoration-none fs-5">MarketPlace</a></p>
            <form action="/pesquisa" method="get" autocomplete="on">
                <input type="text" name="produto" id="ipesquisa" placeholder="Pesquise" required>
                <input type="submit" value="Buscar">
            </form>
            <a href="/login"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
        </menu>
    </header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md border p-1 text-center ">
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <?php
                            array_push($idproduto, $product['idproduto']);
                            array_push($idcarrinho, $product['id']);
                            array_push($estoque, $product['estoque']);
                            ?>
                            <div class='card col-3 mt-3 p-2 d-block m-auto' style='width: 18rem; height:450px'>
                                <img src='<?= $product['foto'] ?>' class='card-img-top rounded' style='height: 220px' alt='...'>
                                <div class='card-body'>
                                    <h5 class='card-title'><?= $product['nome'] ?></h5>
                                    <p class='card-text'><?= $product['descricao'] ?></p>
                                    <p class='card-text'>R$<?= $product['preco'] ?></p>
                                    <a href='/remover?id=<?= $product['id'] ?>' class='btn btn-primary'>Remover Produto</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Nenhum produto encontrado</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <?php if (!empty($products)) : ?>
                <form action='/comprar' method='post'><input type='submit' class='p-1 my-3' value='Finalizar Compra' name='comprou'></form>
            <?php endif; ?>
        </div>

    </main>
</body>


</html>