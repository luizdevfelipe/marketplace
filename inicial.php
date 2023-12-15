<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <style>
    header{
      background-color: yellow;
      padding: 4px;
    }
    menu>p {
      margin-top: 6px;
      width: 10%;
      float: left;
    }

    menu>form {
      width: 80%;
      float: left;
      text-align: center;
      margin-top: 5px;
    }

    menu>form>input[type=submit]{
      border-radius: 4px;
      padding: 1px;
    }

    #ipesquisa {
      width: 60%;
      background-color: white;
      border-radius: 4px;
    }
    a{

      font-size: 30px;
    }
    a::before{
      content: '';
    }
    @media screen and (max-width:740px){
      menu>p {
      display: none;
    }

    menu>form {
      width: 80%;
      float: left;
      text-align: center;
    }

    #ipesquisa {
      width: 60%;
    }
    }
  </style>
</head>

<body>
  <header>
    <menu class="pt-1">
      <p>MarketPlace</p>
      <form action="" method="post">
        <input type="text" name="pesquisa" id="ipesquisa" placeholder="Pesquise">
        <input type="submit" value="Buscar">
      </form>
      <a href="#"><i class="bi bi-person-circle"></i></a>
    </menu>
  </header>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>