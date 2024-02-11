<?php 
namespace Code\Models;

class Queries

{
    private $db;
    public function __construct()
    {
        $this->db = \Code\App::DB();
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
}
