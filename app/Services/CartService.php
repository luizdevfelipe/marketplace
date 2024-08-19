<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Purchase;

class CartService
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
        return Product::select($data)
            ->join('carrinho', 'produtos.id', '=', 'carrinho.idproduto')
            ->where('carrinho.iduser', '=', $_SESSION['id'])
            ->get()->toArray();
    }

    public function removeProduct()
    {
        if (isset($_GET['id'])) {
            Cart::where('id', $_GET['id'])
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

            $estoque = Product::select('estoque')
                ->where('id', $idProduto)
                ->get()->toArray();

            $estoque = $estoque[0]['estoque'] - 1;

            Product::where('id', $idProduto)
                ->update(['estoque' => $estoque]);

            Purchase::insert(['iduser' => $_SESSION['id'], 'idproduto' => $idProduto]);
            Cart::where('idproduto', $idProduto)
                ->delete();
        }
        header('Location: /carrinho');
    }
}
