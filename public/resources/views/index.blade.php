<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>MarketPlace</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
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
    <div id="principal">
      <section id="texto"><strong>
          <mark>Tudo pra você</mark> <br><mark> de P a Q
        </strong></mark></section>
    </div>

    <div class="container-fluid bg-secondary" style="width: 100%; height: 70px;">

    </div>

    <div class="container">
      <div class="d-flex justify-content-evenly flex-wrap">

        <?php foreach ($rows as $row) : ?>

          <div class='card mt-3 p-2' style='width: 18rem; height:450px'>
            <img src='<?= $row['foto'] ?>' class='card-img-top rounded' style='height: 220px' alt='...'>
            <div class='card-body'>
              <h5 class='card-title'> <?= $row['nome'] ?> </h5>
              <p class='card-text'><?= $row['descricao'] ?></p>
              <p class='card-text'>R$ <?= $row['preco'] ?></p>
              <a href='/produto?id=<?= $row['id'] ?>' class='btn btn-primary'>Ver Produto</a>
            </div>
          </div>

        <?php endforeach; ?>
      </div>
    </div>

  </main>

  <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</body>


</html>