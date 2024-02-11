<?php

namespace Code;
use \PDO;

class DB
{
    protected PDO $pdo;
    public function __construct(protected array $env, array $option = [])
    {
        if(empty($option)){
            $option = [
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES=>false
            ];
        }

        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $this->env['DB_HOST'] . ';' . 'dbname=' . $this->env['DB_DATABASE'],
                $this->env['DB_USER'],
                $this->env['DB_PASS'],
                $option
            );
            
        } catch (\Throwable $e){
            echo $e->getMessage();
        }               
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}