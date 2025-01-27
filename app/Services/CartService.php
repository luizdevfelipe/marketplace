<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Purchase;

class CartService
{
    protected $table = 'carrinho';

    public function getMultipleProductsByUserAndCartId(array $productOnCartsIds, int $userId)
    {
        return Product::select('*')
            ->join('carts', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', '=', $userId)
            ->where('products.stock', '>=', 'carts.quantity')
            ->whereIn('carts.id', $productOnCartsIds)
            ->get()->toArray();
    }

    public function getProducts(int $userId)
    {
        return $this->getProductsDataByUser('*', $userId);
    }

    public function getProductsId(int $userId)
    {
        return $this->getProductsDataByUser('carts.product_id', $userId);
    }

    public function userHasProductOnCart(int $productId, int $userId)
    {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
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

    public function changeProductQuantity(int $id, int $quantity): void
    {
        Cart::where('id', $id)
            ->update(['quantity' => $quantity]);
    }

    public function updatePurchaseStatus(string $purchaseId, PaymentStatusEnum $status)
    {
        Purchase::where('purchase_id', $purchaseId)
            ->update(['status' => $status]);
    }

    public function createNewPurchase(string $purchaseId, array $products, int $userId)
    {
        foreach ($products as $product) {
            Purchase::insert([
                'purchase_id' => $purchaseId,
                'user_id' => $userId,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
                'status' => PaymentStatusEnum::PENDING,
            ]);

            $stock = Product::select('stock')
                ->where('id', $product['product_id'])
                ->get()->toArray();

            $stock = $stock[0]['stock'] - $product['quantity'];

            Product::where('id', $product['product_id'])
                ->update(['stock' => $stock]);

            $idCart = Cart::select('id')
                ->where('product_id', $product['product_id'])
                ->get()->toArray();

            $this->removeProduct($idCart[0]['id']);
        }
    }
}
