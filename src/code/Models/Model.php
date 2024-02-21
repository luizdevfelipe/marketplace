<?php 
declare(strict_types=1);

namespace Code\Models;

use Code\DB;
use Code\App;

class Model 
{
    protected DB $db;
    public function __construct()
    {
        $this->db = App::db();
    }
}