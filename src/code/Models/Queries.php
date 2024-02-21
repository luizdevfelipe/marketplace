<?php 
namespace Code\Models;

class Queries extends Model

{
    public function __construct()
    {
        parent::__construct();
    }

    public function simpleSql(string $query, array $data = [])
    {
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute($data);
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        
    }

    public function returnSql(string $query, array $data = []): array
    {
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute($data);
            $result = $stmt->fetchAll();
        } catch (\PDOException $e){
            echo $e->getMessage();
        }    

        return $result ?? null;
    }

    public function erroDisplay(string $msg){
        die("<div style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);font:normal 2em Arial;text-align:center;border:2px solid black;padding:10px;border-radius: 5px;' id='errorDisplay'>$msg<br><br>Volte para a página inicial<br><a href='http://localhost/' style='text-decoration:none; color:white; background-color:green;border-radius: 5px;padding:2px'>Clicando Aqui</a></div>");
    }
}
