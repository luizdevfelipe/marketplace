<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produto[0]['nome'] ?? 'Erro' ?></title>
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
        <div class="container py-2">
            <div class="row">
                <div class="col-12 col-md-7 text-center ">
                    <img src="<?= $produto[0]['foto'] ?>" alt="produto" class="rounded" width="90%" height="400px">
                </div>
                <div class="col-12 col-md-5 border border-dark rounded" id="edita">
                    <h1 class="display-5 text-center"><?= $produto[0]['nome'] ?></h1>
                    <p class="mt-5 fs-5"><?= $produto[0]['descricao'] ?></p>
                    <p class="mb-0">Produtos Disponíveis: <?= $produto[0]['estoque'] ?></p>
                    <p class="text-success fs-5">R$<?= $produto[0]['preco'] ?></p>

                    <form action='/produto' method='post'>
                        <input type='submit' class='btn btn-success' value='Adicionar ao carrinho' name='comprar'>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>