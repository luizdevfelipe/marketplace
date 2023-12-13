<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body,
        html {
            background-image: url("images/caixas-pc.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <?php
    function validar($dado)
    {
        $dado = trim($dado);
        $dado = stripslashes($dado);
        $dado = htmlspecialchars($dado);
        return $dado;
    }

    $nome = $senha = $a = $erro = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = validar($_POST["user"]);
        $senha = validar($_POST["senha"]);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "marketplace";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die($conn->connect_error);
        }

        $sql = "SELECT * FROM usuarios WHERE nome = '" . $nome . "' AND senha = '" . $senha . "' ";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            $a = "window.location.href = 'http://localhost/marketplace/inicial.php'";
        } else {
            $erro = "Usuário ou senha inválidos";
        }

        $conn->close();
    }
    ?>

    <fieldset class="centralizado border border-dark rounded text-center w350">
        <legend class="mt-1 display-6">Login</legend>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="on">
            <label for="iuser" class="mt-1 lead">Nome de Usuário:</label><br>
            <input type="text" class="p-1" name="user" id="iuser" autocomplete="username" required minlength="4" maxlength="50"><br>

            <label for="isenha" class="mt-1 lead">Insira sua Senha:</label><br>
            <input type="password" class="p-1" name="senha" id="isenha" autocomplete="current-password" minlength="8" required maxlength="15"><br>

            <input class="btn btn-success my-2" type="submit" value="Entrar">
        </form>

        <div class="erro bg-white text-danger rounded m-2 fs-5">
            <?= $erro ?>
        </div>
    </fieldset>

    <div class="text-center lead">
        <p>Não tem cadastro? <br><a href="registro.php" class="text-success text-decoration-none">Registre-se</a> agora</p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        <?=$a?>
    </script>
</body>

</html>