<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'MarketPlace')</title>
  @yield('head', '')
  <link rel="shortcut icon" href="/resources/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="/resources/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <script src="/resources/js/layout.js"></script>
</head>

<body>
  <header>
    <menu class="pt-1">
      <p class="p-0 m-0"><a href="/" class="text-decoration-none fs-5">MarketPlace</a></p>
      <div class="menuForm">
        <input type="text" name="produto" id="ipesquisa" placeholder="Pesquise" required>
        <button class="btn bg-primary text-white" id="buscarProduto">Buscar</button>
      </div>
      <a href="/perfil"><i class="bi bi-person-circle ms-1 fs-3"></i></a>
      <a href="/carrinho"><i class="bi bi-cart3 ms-1 fs-3"></i></a>
    </menu>
  </header>

  <section>
    @yield('body')
  </section>

</body>

</html>