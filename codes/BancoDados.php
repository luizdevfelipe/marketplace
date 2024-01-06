<?php
class BancoDados
{
    private $conn;
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die('Erro de Conexão');
        }
    }

    public function close(){
        $this->conn->close();
    }

    public function simpleSql(string $sql)
    {
        try {
            $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            die('Erro com banco de dados' . $e);
        }
    }

    public function returnSql(string $sql)
    {
        try {
            $query = $this->conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            die("Erro com banco de dados" . $e);
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
}


/* $conexao = new BancoDados(asdad asdasd asdasd asdasd asdasd);
    $conexao->conect();

    $conexao->sql();
*/