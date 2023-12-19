<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Perfil</title>
    <link rel="stylesheet" href="../estilos/perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>

    <header>
        <menu class="pt-1">
            <p class="p-0 m-0"><a href="../index.php" class="text-decoration-none fs-5">MarketPlace</a></p>
            <form action="" method="post">
                <input type="text" name="pesquisa" id="ipesquisa" placeholder="Pesquise">
                <input type="submit" value="Buscar">
            </form>
            <a href="carrinho.php"><i class="bi bi-cart3 ms-1"></i></a>
        </menu>
    </header>

    <main>
        <?php 
            session_start();
            $id = $_SESSION['id'];           

            function validar($dado){
                $dado = trim($dado);
                $dado = stripslashes($dado);
                $dado = htmlspecialchars($dado);
                return $dado;
            }

            $nome = $sobrenome = $estado = $cidade = $foto = '';
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $servername = 'localhost';
                $username = 'root';
                $password = '';
                $dbname = 'marketplace';

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error){
                    die($conn->connect_error);
                }
                //if valores acima já cadastrados, exiba-os

                //else cadastre os valores
                $nome = validar($_POST["nome"]);
                $sobrenome = validar($_POST["sobrenome"]);
                $estado = validar($_POST["estado"]);
                $cidade = validar($_POST["cidade"]);

                $sql = "INSERT INTO  usuarios (nome, sobrenome, estado, cidade) VALUES ('".$nome."', '".$sobrenome."', '".$estado."', '".$cidade."')";

                if($conn->query($sql) === TRUE){
                    echo "Cadastrado";
                }


                $conn->close();
            }
            
        ?>
        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-md-4 text-center text-md-start">
                    <img src="" alt="" class="align-center" style="width: 200px; height:200px"><br>
                    <label for="ifoto" class="border border-dark rounded p-1 mt-1 text-center" style="width: 200px;">Clique e envie a Imagem</label><br>
                   
                </div>
                <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded">
                    <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" autocomplete="on">
                    <input type="file" name="foto" id="ifoto" style="display: none;">

                        <label for="inome" class="mb-2" style="margin-right: 40px;">Nome: *</label>
                        <input type="text" name="nome" id="inome" maxlength="20" minlength="4" required><br>

                        <label for="isobrenome" class="mb-2">Sobrenome: *</label>
                        <input type="text" name="sobrenome" id="isobrenome" maxlength="20" minlength="4" required><br>

                        <label for="iestado" class="mb-2" style="margin-right: 33px;">Estado: *</label>
                        <select name="estado" id="iestado" class="p-1" style="width: 199px;" required>                            
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select> <br>

                        <label for="icidade" style="margin-right: 32px;">Cidade: *</label>
                        <input type="text" name="cidade" id="icidade" maxlength="20" minlength="4" required><br>

                        <input type="submit" value="Enviar" class="mt-2 p-1">

                    </form>
                </div>
            </div>
        </div>


    </main>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>