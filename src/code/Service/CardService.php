<?php

declare(strict_types=1);

namespace Code\Service;

use Code\Models\Carrinho;
use Code\Models\Compras;
use Code\Models\Produtos;

class
CardService
{
    protected $table = 'carrinho';

    public function getProducts()
    {
        return $this->getProductsDataByUser('*');
    }

    public function getProductsId()
    {
        return $this->getProductsDataByUser('carrinho.idproduto');
    }

    public function getProductsDataByUser(string $data)
    {
        return Produtos::select($data)
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

    public function buyProducts()
    {
        $products = $this->getProductsId();

        foreach ($products as $product) {
            $idProduto = $product['idproduto'];

            $estoque = Produtos::select('estoque')
                ->where('id', $idProduto)
                ->get()->toArray();

            $estoque = $estoque[0]['estoque'] - 1;

            Produtos::where('id', $idProduto)
                ->update(['estoque' => $estoque]);

            Compras::insert(['iduser' => $_SESSION['id'], 'idproduto' => $idProduto]);
            Carrinho::where('idproduto', $idProduto)
                ->delete();
        }
        header('Location: /carrinho');
    }
}
