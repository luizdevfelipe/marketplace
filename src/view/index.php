<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MarketPlace</title>
  <link rel="shortcut icon" href="images/site/favicon_io/favicon.ico" type="image/x-icon">
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
      <a href="/registro"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
      <a href="/carrinho"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
    </menu>

    <style>
      @charset "UTF-8";

      @import url('https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap');

      <?php
      ob_start();
      include VIEW_PATH . '/' . 'style.css';
      echo (string) ob_get_clean();
      ?>
    </style>
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

      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>