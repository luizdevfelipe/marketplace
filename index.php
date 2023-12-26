<!DOCTYPE html>
<html lang="pt-br">

<?php
$mercadorias = '';

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'marketplace';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("<h1><a href='http://localhost/marketplace/'>Erro de conexão</a></h1>");
}

$sql = "SELECT * FROM produtos ORDER BY nome ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0){
  while ($row = $result->fetch_assoc()) {
  $mercadorias .= "<div class='card col-3 mt-3 p-2 d-block m-auto' style='width: 18rem; height:450px'><img src='user/" . $row["foto"] . "' class='card-img-top rounded' style='height: 220px' alt='...'><div class='card-body'><h5 class='card-title'>". $row['nome'] ."</h5><p class='card-text'>". $row['descricao'] ."</p><p class='card-text'>R$".  $row['preco'] ."</p><a href='user/produto.php?id=". $row['id'] ."' class='btn btn-primary'>Ver Produto</a></div></div>";
}
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MarketPlace</title>
  <link rel="shortcut icon" href="images/favicon_io/favicon.ico" type="image/x-icon">
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
      <a href="user/carrinho.php"><i class="bi bi-cart3 ms-1"></i></a>
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
       <?=$mercadorias?>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>