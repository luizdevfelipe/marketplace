<?php

namespace Code\Controller;

use Code\Attributes\Get;
use Code\Models\Produtos;
use \Code\View;

class HomeController

{
    #[Get('/')]
    public function index()
    {
        $result = Produtos::select('*')
            ->where('estoque', '>', 0)
            ->orderBy('nome', 'asc')
            ->limit(6)
            ->get()->toArray();        

        return View::make('index', ['rows' => $result]);
    }
}
