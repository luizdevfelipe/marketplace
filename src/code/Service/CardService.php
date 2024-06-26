<?php

declare(strict_types=1);

namespace Code\Service;

use Code\Models\Carrinho;
use Code\Models\Produtos;

class CardService
{
    protected $table = 'carrinho';

    public function getProducts()
    {
        return Produtos::select('*')
            ->join('carrinho', 'produtos.id', '=', 'carrinho.idproduto')
            ->where('carrinho.iduser', '=', $_SESSION['id'])
            ->get()->toArray();    
    }

    public function removeProduct()
    {
        if (isset($_GET['id'])) {
            Carrinho::where('id', $_GET['id'])
            ->delete();           
            header('Location: /carrinho');
        } else {
            echo 'erro ao remover produto';
        }
    }
}
