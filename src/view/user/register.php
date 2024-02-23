<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="shortcut icon" href="storage/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="storage/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body,
        html {
            height: 100vh;
            width: 100vw;
            background-image: url("storage/site/caixas.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        input {
            background-color: transparent;
        }

        input:focus {
            background-color: white;
        }

        fieldset {
            background-color: rgba(0, 0, 0, 0.082);
        }

        a::before {
            content: "\01F517";
        }

        .w350 {
            width: 350px;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-grid justify-content-center align-content-center" style="height: 100vh;">
        <fieldset class="border border-dark rounded text-center w350">
            <legend class="mt-1 display-6" id="legenda">Registro</legend>
            <form action="<?= htmlspecialchars('/registro') ?>" method="post" autocomplete="on" id="form">
                <label for='iuser' class='mt-1 lead'>Nome de Usuário:</label><br>Este nome só será usado para acesso ao site<br><input type='text' class='p-1' name='user' id='iuser' autocomplete='username' required minlength='4' maxlength='50' placeholder=' Usuário'><br><label for='isenha1' class='mt-1 lead'>Insira sua Senha:</label><br><input type='password' class='p-1' name='senha1' id='isenha1' autocomplete='current-password' minlength='8' required maxlength='15' placeholder=' Senha'><br><label for='isenha2' class='mt-1 lead'>Repita a Senha:</label><br><input type='password' class='p-1' name='senha2' id='isenha2' autocomplete='current-password' required minlength='8' maxlength='15' placeholder=' Repita Senha'><br> <input class='btn btn-success my-2' type='submit' value='Entrar'>
            </form>
            <?php if (isset($erro)) : ?>
                <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
                    <?= $erro ?>
                </div>
            <?php endif; ?>
        </fieldset>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>