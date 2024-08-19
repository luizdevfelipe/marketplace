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
    <div class="container-fluid d-grid justify-content-center align-content-center" style="height: 100vh;">
        <fieldset class="border border-dark rounded text-center w350">
            <legend class="mt-1 display-6" id="legenda">Registro</legend>
            <form action="<?= htmlspecialchars('/registro') ?>" method="post" autocomplete="on" id="form">
                <label for='iemail' class="lead">Email:</label><br><input type='text' name='email' id='iemail' maxlength='20' minlength='4' required><br>
                <label for='inome' class="lead">Nome:</label><br><input type='text' name='nome' id='inome' maxlength='20' minlength='4' required><br>
                <label for='isobrenome' class='mb-1 lead'>Sobrenome:</label><br><input type='text' name='sobrenome' id='isobrenome' maxlength='20' minlength='4' required><br>
                <label for='iestado' class='mb-1 lead'>Estado:</label><br><select name='estado' id='iestado' class='p-1' style='width: 199px;' required>
                    <option value='AC'>Acre</option>
                    <option value='AL'>Alagoas</option>
                    <option value='AP'>Amapá</option>
                    <option value='AM'>Amazonas</option>
                    <option value='BA'>Bahia</option>
                    <option value='CE'>Ceará</option>
                    <option value='DF'>Distrito Federal</option>
                    <option value='ES'>Espírito Santo</option>
                    <option value='GO'>Goiás</option>
                    <option value='MA'>Maranhão</option>
                    <option value='MT'>Mato Grosso</option>
                    <option value='MS'>Mato Grosso do Sul</option>
                    <option value='MG'>Minas Gerais</option>
                    <option value='PA'>Pará</option>
                    <option value='PB'>Paraíba</option>
                    <option value='PR'>Paraná</option>
                    <option value='PE'>Pernambuco</option>
                    <option value='PI'>Piauí</option>
                    <option value='RJ'>Rio de Janeiro</option>
                    <option value='RN'>Rio Grande do Norte</option>
                    <option value='RS'>Rio Grande do Sul</option>
                    <option value='RO'>Rondônia</option>
                    <option value='RR'>Roraima</option>
                    <option value='SC'>Santa Catarina</option>
                    <option value='SP'>São Paulo</option>
                    <option value='SE'>Sergipe</option>
                    <option value='TO'>Tocantins</option>
                </select> <br>
                <label for='icidade' class="lead">Cidade:</label><br><input type='text' name='cidade' id='icidade' title='Somente primeira letra maiúscula mínimo de 3 caracteres' maxlength='20' required><br>
                <label for='isenha1' class='mt-1 lead'>Insira sua Senha:</label><br><input type='password' class='p-1' name='senha1' id='isenha1' autocomplete='current-password' minlength='8' required maxlength='15' placeholder=' Senha'><br>
                <label for='isenha2' class='mt-1 lead'>Repita a Senha:</label><br><input type='password' class='p-1' name='senha2' id='isenha2' autocomplete='current-password' required minlength='8' maxlength='15' placeholder=' Repita Senha'><br> <input class='btn btn-success my-2' type='submit' value='Entrar'>
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