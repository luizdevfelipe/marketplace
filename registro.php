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
    <?php
        function validar($dado){
            $dado = trim($dado);
            $dado = stripslashes($dado);
            $dado = htmlspecialchars($dado);
            return $dado;
        }

        $user = $senha1 = $senha2 = $erro = $cor = $a = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = validar($_POST["user"]);
            $senha1 = validar($_POST["senha1"]);
            $senha2 = validar($_POST["senha2"]);


            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "marketplace";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error){
                die($conn->connect_error);
            }      

            if ($senha1 == $senha2){
                $senha = $senha1;
               
                $sql = "INSERT INTO usuarios (nome, senha) VALUES ('".$user."', '".$senha."')";

                if ($conn->query($sql)){
                    $erro = "Cadastro Realizado!";
                    $a = '<buttom class="btn bg-success text-white mb-2" onclick="javascript:history.go(-2)">Clique aqui para voltar</buttom>';
                    $cor = "text-success";
                } 

            } else {
                $erro = 'Senhas Diferentes!';
                $cor = "text-danger";
            }
            
            $conn->close();
        }

    ?>

    <fieldset class="centralizado border border-dark rounded text-center w350">
        <legend class="mt-1 display-6">Registre-se</legend>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="on">
        <label for="user" class="mt-1 lead">Nome de Usuário:</label><br>
        <input type="text" class="p-1" name="user" id="iuser" autocomplete="name" required minlength="4" maxlength="50" value="<?=$user?>"><br>

        <label for="senha" class="mt-1 lead">Insira sua Senha:</label><br>
        <input type="password" class="p-1" name="senha1" id="isenha1" autocomplete="current-password" minlength="8" required maxlength="15"><br>

        <label for="senha" class="mt-1 lead">Repita a Senha:</label><br>
        <input type="password" class="p-1" name="senha2" id="isenha2" autocomplete="current-password" required minlength="8" maxlength="15"><br>

        <input class="btn btn-success my-2" type="submit" value="Entrar">
        </form>

        <div class="erro bg-white <?=$cor?> rounded m-2 fs-5">
            <?=$erro?>
            <?=$a?>
        </div>        
    </fieldset>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>