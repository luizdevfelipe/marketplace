<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="estilos/login.css">
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

    $user = $senha = $senha1 = $senha2 = $erro = $cor = $p = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "marketplace";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die($conn->connect_error);
        }

        if (count($_POST) == 2) {
            $nome = validar($_POST["user"]);
            $senha = validar($_POST["senha"]);

            $sql = "SELECT * FROM usuarios WHERE nome = '" . $nome . "' AND senha = '" . $senha . "' ";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $p = "window.location.href = 'http://localhost/marketplace/user/perfil.php'";
            } else {
                $erro = "Usuário ou senha inválidos";
                $cor = "text-danger";
            }
        } else {
            $user = validar($_POST["user"]);
            $senha1 = validar($_POST["senha1"]);
            $senha2 = validar($_POST["senha2"]);

            if ($senha1 == $senha2) {
                $senha = $senha1;

                $sql = "SELECT nome FROM usuarios WHERE nome = '" . $user . "'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $p = "Registrar()";
                    $erro = 'Usuário já cadastrado!';
                    $cor = "text-danger";
                    
                } else {
                    $sql = "INSERT INTO usuarios (nome, senha) VALUES ('" . $user . "', '" . $senha . "')";

                    if ($conn->query($sql) === TRUE) {
                        $erro = "Cadastro Realizado!";
                        $cor = "text-success";
                    }
                }
            } else {
                $erro = 'Senhas Diferentes!';
                $cor = "text-danger";
                $p = "Registrar()";
            }
        }
        $conn->close();
    }
    ?>

    <fieldset class="centralizado border border-dark rounded text-center w350">
        <legend class="mt-1 display-6" id="legenda">Login</legend>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="on" id="form">
            <label for="iuser" class="mt-1 lead">Nome de Usuário:</label><br>
            <input type="text" class="p-1" name="user" id="iuser" autocomplete="username" required minlength="4" maxlength="50"><br>

            <label for="isenha" class="mt-1 lead">Insira sua Senha:</label><br>
            <input type="password" class="p-1" name="senha" id="isenha" autocomplete="current-password" minlength="8" required maxlength="15"><br>

            <input class="btn btn-success my-2" type="submit" value="Entrar">
        </form>

        <div id="diverro" class="erro bg-white <?= $cor ?> rounded m-2 fs-5">
            <?= $erro ?>
        </div>
    </fieldset>

    <div class="text-center lead" id="registro">
        <p>Não tem cadastro? <br><button class="btn bg-success border border-dark p-1 text-white" onclick="Registrar()">Registre-se</button> agora</p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        <?= $p ?>

        function Registrar() {
            //document.getElementById('diverro').innerHTML = ''
            form = document.querySelector('form#form')
            legend = document.querySelector('legend#legenda')
            document.getElementById('registro').style.display = 'none'

            legend.innerHTML = 'Registre-se'
            form.innerHTML = "<label for='iuser' class='mt-1 lead'>Nome de Usuário:</label><br><input type='text' class='p-1' name='user' id='iuser' autocomplete='username' required minlength='4' maxlength='50'><br><label for='isenha1' class='mt-1 lead'>Insira sua Senha:</label><br><input type='password' class='p-1' name='senha1' id='isenha1' autocomplete='current-password' minlength='8' required maxlength='15'><br><label for='isenha2' class='mt-1 lead'>Repita a Senha:</label><br><input type='password' class='p-1' name='senha2' id='isenha2' autocomplete='current-password' required minlength='8' maxlength='15'><br><input class='btn btn-success my-2' type='submit' value='Entrar'>"
        }
    </script>
</body>

</html>