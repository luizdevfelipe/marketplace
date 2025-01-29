<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'MarketPlace')</title>
  @yield('head', '')
  <link rel="shortcut icon" href="{{ Vite::asset('resources/images/favicon.ico') }}" type="image/x-icon">
  @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/js/layout.js'])
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