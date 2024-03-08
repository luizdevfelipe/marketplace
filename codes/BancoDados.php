<?php
class BancoDados
{
    private $conn;

    public function __construct(private string $servername, private string $username, private string $password, private string $dbname)
    {        
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            $this->erroDisplay('Erro Inesperado!');
        }
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function simpleSql(string $sql)
    {
        try {
            $this->conn->query($sql);
        } catch (mysqli_sql_exception) {
            $this->erroDisplay('Erro Inesperado!');
        }
        return true;
    }

    public function returnSql(string $sql)
    {
        try {
            $query = $this->conn->query($sql);
        } catch (mysqli_sql_exception) {
            $this->erroDisplay('Erro Inesperado!');
        }
        return $query;
    }

    public function validar($dado)
        {
            $dado = trim($dado);
            $dado = stripslashes($dado);
            $dado = htmlspecialchars($dado);           
            return $dado;
        }
            
        

    public function erroDisplay(string $msg){
        die("<header><menu class='pt-1'><p class='p-0 m-0'><a href='index.php' class='text-decoration-none fs-5'>MarketPlace</a></p><form action='http://localhost/marketplace/pesquisa.php' method='get' autocomplete='on'><input type='text' name='produto' id='ipesquisa' placeholder='Pesquise'><input type='submit' value='Buscar'></form><a href='login.php'><i class='bi bi-person-circle ms-1 fs-3'></i></a><a href='carrinho.php'><i class='bi bi-cart3 ms-1 fs-3'></i></a></menu></header><div style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);font:normal 2em Arial;text-align:center;border:2px solid black;padding:10px;border-radius: 5px;' id='errorDisplay'>$msg<br><br>Volte para a página inicial<br><a href='http://localhost/marketplace/index.php' style='text-decoration:none; color:white; background-color:green;border-radius: 5px;padding:2px'>Clicando Aqui</a></div>");
    }
}