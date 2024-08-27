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
        return $this->getProductsDataByUser('carts.product_id');
    }

    public function getProductsDataByUser(string $data)
    {
        return Product::select($data)
            ->join('carts', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', '=', session()->get('id'))
            ->get()->toArray();
    }

    public function removeProduct(int $id): void
    {
        Cart::where('id', $id)
            ->delete();
    }

    public function buyProducts(array $products_ids)
    {
        foreach ($products_ids as $id) {
            $stock = Product::select('stock')
                ->where('id', $id['product_id'])
                ->get()->toArray();

            if ($stock[0]['stock'] > 0) {
                $stock = $stock[0]['stock'] - 1;

                Product::where('id', $id['product_id'])
                    ->update(['stock' => $stock]);

                Purchase::insert(['user_id' => session()->get('id'), 'product_id' => $id['product_id']]);

                $idCart = Cart::select('id')
                ->where('product_id', $id['product_id'])
                ->get()->toArray();

                Cart::where('id', $idCart[0]['id'])
                    ->delete();
            } else {
                continue;
            }
        }
    }
}
