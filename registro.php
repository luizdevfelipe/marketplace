<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body, html{
            background-image: url("images/caixas-pc.jpg");
            background-size: cover;
            background-repeat: no-repeat;            
        }
    </style>
</head>

<body>

    <fieldset class="centralizado border border-dark rounded text-center w350">
        <legend class="mt-1 display-6">Registre-se</legend>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="on">
        <label for="user" class="mt-1 lead">Nome de Usuário:</label><br>
        <input type="text" class="p-1" name="user" id="iuser" autocomplete="name" required><br>

        <label for="senha" class="mt-1 lead">Insira sua Senha:</label><br>
        <input type="password" class="p-1" name="senha" id="isenha" autocomplete="current-password" required><br>

        <label for="senha" class="mt-1 lead">Repita a Senha:</label><br>
        <input type="password" class="p-1" name="senha" id="isenha" autocomplete="current-password" required><br>

        <input class="btn btn-success my-2" type="submit" value="Entrar">
        </form>
    </fieldset>

    <!-- <div class="text-center lead">
        <p>Não tem cadastro? <br><a href="registro.php" class="text-success text-decoration-none">Registre-se</a> agora</p>
    </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>