<?php

namespace Code\Controller;

use \Code\View;
use \Code\Models\Queries;

class HomeController

{
    public function index()
    {
        $mysql = new Queries();
        $result =  $mysql->returnSql("SELECT * FROM produtos WHERE estoque > 0  ORDER BY nome ASC LIMIT 6", fetchAll: true);

        return View::make('index', ['rows' => $result]);
    }
}
