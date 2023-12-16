<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="estilos/inicial.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
  


  <header>
    <menu class="pt-1">
      <p>MarketPlace</p>
      <form action="" method="post">
        <input type="text" name="pesquisa" id="ipesquisa" placeholder="Pesquise">
        <input type="submit" value="Buscar">
      </form>
      <a href="login.php"><i class="bi bi-person-circle"></i></a>
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
      <div class="row">

        <div class="card col-3 mt-3 d-block m-auto" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Bicicleta</h5>
            <p class="card-text">Bicicleta usada aro 29 freio a disco 24 marchas</p>
            <p class="card-text">R$ 600</p>
            <a href="#" class="btn btn-primary">Ver Produto</a>
          </div>
        </div>

        <div class="card col-3 mt-3 d-block m-auto" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>

        <div class="card col-3 mt-3 d-block m-auto" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>

        <div class="card col-3 mt-3 d-block m-auto" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>


        <div class="card col-3 mt-3 d-block m-auto" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>


      </div>
    </div>


  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


  <script>
    function Perfil(){
      if (<?=$nome?> == ''){
        window.location.href = 'http://localhost/marketplace/login.php'
      } else {  
        window.location.href = 'http://localhost/marketplace/perfil.php'
      }
    }
  </script>

</body>

</html>