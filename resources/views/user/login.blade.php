<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Página de Login</title>
    <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="resources/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body,
        html {
            height: 100vh;
            width: 100vw;
            background-image: url("resources/site/caixas.jpg");
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
    <div class="container-fluid d-grid justify-content-center" style="height: 100vh;">
        <div class="lead text-center" id="registro">
            <p>Não tem cadastro? <br><a class="btn bg-success border border-dark p-1 text-white" href="/registro">Registre-se</a> agora</p>
        </div>
        <fieldset class="border border-dark rounded text-center w350" style="height: 310px;">
            <legend class="mt-1 display-6" id="legenda">Login</legend>
            <form action="<?= htmlspecialchars('/login') ?>" method="post" autocomplete="on" id="form">
                @csrf
                <label for="iemail" class="mt-1 lead">Email:</label><br>
                <input type="text" class="p-1" name="email" id="iemail" autocomplete="email" required minlength="4" maxlength="50"><br>
                <label for="isenha" class="mt-1 lead">Insira sua Senha:</label><br>
                <input type="password" class="p-1" name="senha" id="isenha" autocomplete="current-password" minlength="8" required maxlength="15"><br>
                <input class="btn btn-success mt-3" type="submit" value="Entrar">
            </form>
                <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
                    <?= $erro ?? ''?>
                </div>
        </fieldset>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>