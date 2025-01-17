<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Purchase;

class CartService
{
    protected $table = 'carrinho';

    public function getProducts(int $userId)
    {
        return $this->getProductsDataByUser('*', $userId);
    }

    public function getProductsId(int $userId)
    {
        return $this->getProductsDataByUser('carts.product_id', $userId);
    }

    public function getProductsDataByUser(string $data, int $userId)
    {
        return Product::select($data)
            ->join('carts', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', '=', $userId)
            ->get()->toArray();
    }

    public function removeProduct(int $id): void
    {
        Cart::where('id', $id)
            ->delete();
    }

    public function updatePurchaseStatus(string $purchaseId, PaymentStatusEnum $status)
    {
        Purchase::where('purchase_id', $purchaseId)
            ->update(['status' => $status]);
    }

    public function createNewPurchase(string $purchaseId, array $products, int $userId)
    {
        foreach ($products as $product) {
            $stock = Product::select('stock')
                ->where('id', $product['product_id'])
                ->get()->toArray();

            if ($stock[0]['stock'] > 0) {

                Purchase::insert([
                    'purchase_id' => $purchaseId,
                    'user_id' => $userId,
                    'product_id' => $product['product_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'status' => PaymentStatusEnum::PENDING,
                ]);

                $idCart = Cart::select('id')
                    ->where('product_id', $product['product_id'])
                    ->get()->toArray();

                $this->removeProduct($idCart[0]['id']);
            } else {
                continue;
            }
        }
    }

    public function buyProducts(string $purchaseId)
    {
        $this->updatePurchaseStatus($purchaseId, PaymentStatusEnum::APPROVED);

        $productsId = Purchase::select('product_id')
            ->where('purchase_id', $purchaseId)
            ->get()->toArray();

        foreach ($productsId as $productId) {
            $stock = Product::select('stock')
                ->where('id', $productId['product_id'])
                ->get()->toArray();

            $stock = $stock[0]['stock'] - 1;

            Product::where('id', $productId['product_id'])
                ->update(['stock' => $stock]);
        }
    }
}
