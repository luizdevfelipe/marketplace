<?php

namespace Code;

class DB
{
    protected \PDO $pdo;
    public function __construct(protected $host, protected $user, protected $password, protected $db)
    {
        $this->pdo = new \PDO(
            'mysql:host=' . $this->host . ';' . 'dbname=' . $this->db,
            $this->user,
            $this->password
        );
    }
}
