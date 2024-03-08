<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="shortcut icon" href="images/site/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="estilos/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body,
        html {
            height: 100vh;
            width: 100vw;
            background-image: url("images/site/caixas.jpg");
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
    <?php
    date_default_timezone_set('America/Sao_Paulo');
    session_start();
    if (isset($_SESSION["id"])) {
        $p = "window.location.href = 'http://localhost/marketplace/perfil.php'";
    } else {
        require_once "codes/BancoDados.php";

        $user = $senha = $senha1 = $senha2 = $erro = $cor = $p = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $conexao = new BancoDados('localhost', 'root', '', 'marketplace');

            if (count($_POST) == 2) {
                $email = $conexao->validar($_POST["email"]);
                $senha = $conexao->validar($_POST["senha"]);

                $resultado = $conexao->returnSql("SELECT id FROM usuarios WHERE email = '$email' AND senha = '$senha' ");

                if ($resultado->num_rows > 0) {
                    $p = "window.location.href = 'http://localhost/marketplace/perfil.php'";
                    $vet = $resultado->fetch_assoc();
                    $_SESSION['id'] = $vet["id"];
                } else {
                    $erro = "Email ou senha inválidos";
                    $cor = "text-danger";
                }
            } else {
                $email = $conexao->validar($_POST["email"]);
                $nome = $conexao->validar($_POST["nome"]);
                $sobrenome = $conexao->validar($_POST["sobrenome"]);
                $cidade = $conexao->validar($_POST["cidade"]);
                $estado = $conexao->validar($_POST["estado"]);
                $senha1 = $conexao->validar($_POST["senha1"]);
                $senha2 = $conexao->validar($_POST["senha2"]);

                if ($senha1 == $senha2) {

                    $result = $conexao->returnSql("SELECT email FROM usuarios WHERE email = '" . $email . "'");
                    if ($result->num_rows > 0) {
                        $p = "Registrar()";
                        $erro = 'Usuário já cadastrado!';
                        $cor = "text-danger";
                    } else {
                        $lenNome = strlen($email);
                        $lenSenha = strlen($senha);
                        if (!empty($senha1) && !empty($email) && $lenNome <= 50 && $lenSenha <= 15) {
                            $conexao->simpleSql("INSERT INTO usuarios (email, senha, nome, sobrenome, estado, cidade, datacadastro) VALUES ('$email', '$senha1', '$nome', '$sobrenome', '$estado', '$cidade', '".date('Y-m-d H:i:s')."')");
                            $erro = "Cadastro Realizado!";
                            $cor = "text-success";
                        } else {
                            $erro = 'Insira dados Válidos!';
                            $cor = "text-danger";
                            $p = "Registrar()";
                        }
                    }
                } else {
                    $erro = 'Senhas Diferentes!';
                    $cor = "text-danger";
                    $p = "Registrar()";
                }
            }
        }
    }
    ?>

    <div class="container-fluid d-grid justify-content-center align-content-center" style="height: 100vh;">
        <div class="lead text-center" id="registro">
            <p>Não tem cadastro? <br><button class="btn bg-success border border-dark p-1 text-white" onclick="Registrar()">Registre-se</button> agora</p>
        </div>
        <fieldset class="border border-dark rounded text-center w350">
            <legend class="mt-1 display-6" id="legenda">Login</legend>
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="on" id="form" style="text-shadow: 0px 0px 0px black;">
                <label for="iuser" class="mt-1 lead">Email:</label><br>
                <input type="text" class="p-1" name="email" id="iemail" autocomplete="email" required minlength="4" maxlength="50"><br>
                <label for="isenha" class="mt-1 lead">Insira sua Senha:</label><br>
                <input type="password" class="p-1" name="senha" id="isenha" autocomplete="current-password" minlength="8" required maxlength="15"><br>
                <input class="btn btn-success my-2" type="submit" value="Entrar">
            </form>
            <div id="diverro" class="erro bg-white <?= $cor ?> rounded m-2 fs-5">
                <?= $erro ?>
            </div>
        </fieldset>
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
            form.innerHTML = "<label for='inome' class='mt-1 lead'>Nome:</label><br><input type='text' class='p-1' name='nome' id='inome' required minlength='2' maxlength='25' placeholder=' Seu nome'><br><label for='isobrenome' class='mt-1 lead'>Sobrenome:</label><br><input type='text' class='p-1' name='sobrenome' id='isobrenome' required minlength='2' maxlength='25' placeholder=' Seu Sobrenome'><br><label for='iemail' class='mt-1 lead'>Email:</label><br><input type='text' class='p-1' name='email' id='iemail' autocomplete='email' required minlength='4' maxlength='50' placeholder=' Email'><br><label for='isenha1' class='mt-1 lead'>Insira sua Senha:</label><br><input type='password' class='p-1' name='senha1' id='isenha1' autocomplete='current-password' minlength='8' required maxlength='15'  placeholder=' Senha'><br><label for='isenha2' class='mt-1 lead'>Repita a Senha:</label><br><input type='password' class='p-1' name='senha2' id='isenha2' autocomplete='current-password' required minlength='8' maxlength='15' placeholder=' Repita Senha'> <br><label for='icidade' class='mt-1 lead'>Cidade:</label><br><input type='text' class='p-1' name='cidade' id='icidade' required maxlength='30' placeholder=' Sua Cidade'><br>   <label for='iestado' class='mt-1 lead' >Estado:</label><br><select name='estado' id='iestado' class='p-1' style='width: 199px;' required><option selected disabled>Selecione o Estado</option><option value='AC'>Acre</option><option value='AL'>Alagoas</option><option value='AP'>Amapá</option><option value='AM'>Amazonas</option><option value='BA'>Bahia</option><option value='CE'>Ceará</option><option value='DF'>Distrito Federal</option><option value='ES'>Espírito Santo</option><option value='GO'>Goiás</option><option value='MA'>Maranhão</option><option value='MT'>Mato Grosso</option><option value='MS'>Mato Grosso do Sul</option><option value='MG'>Minas Gerais</option><option value='PA'>Pará</option><option value='PB'>Paraíba</option><option value='PR'>Paraná</option><option value='PE'>Pernambuco</option><option value='PI'>Piauí</option><option value='RJ'>Rio de Janeiro</option><option value='RN'>Rio Grande do Norte</option><option value='RS'>Rio Grande do Sul</option><option value='RO'>Rondônia</option><option value='RR'>Roraima</option><option value='SC'>Santa Catarina</option><option value='SP'>São Paulo</option><option value='SE'>Sergipe</option><option value='TO'>Tocantins</option></select><br>     <input class='btn btn-success my-2' type='submit' value='Entrar'>"
        }

       
    </script>
</body>

</html>