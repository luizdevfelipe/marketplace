<?php 
namespace Code\Models;

class Queries extends Model

{
    public function __construct()
    {
        parent::__construct();
    }

    public function simpleSql(string $query, array $data = [], bool $id = false)
    {
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute($data);
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        if ($id){
            return (int) $this->db->lastInsertId();
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
