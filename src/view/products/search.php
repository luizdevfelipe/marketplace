<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosso Produtos</title>
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
            <a href="/login"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
            <a href="/carrinho"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
        </menu>
    </header>

    <main>
        <div class="container text-center">
            <?php if (!empty($results) && $results !== '') : ?>
                <?php foreach ($results as $row) : ?>

                    <div class='card d-block m-auto mt-3 p-2' style='width: 18rem; height:450px'><img src='<?= $row["foto"] ?>' class='card-img-top rounded' style='height: 220px' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'><?= $row['nome'] ?></h5>
                            <p class='card-text'><?= $row['descricao'] ?></p>
                            <p class='card-text'>R$<?= $row['preco'] ?></p><a href="/produto?id=<?= $row['id'] ?>" class='btn btn-primary'>Ver Produto</a>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <div class="container border border-dark rounded mt-5 d-block m-auto">
                    <h1 class="text-center p-5"> Produto não encontrado &#x1F641;<br>Tente utilizar palavras mais curtas como: pipoca, prato ou panela.</h1>
                </div>


            <?php endif; ?>
        </div>
    </main>

</body>

</html>