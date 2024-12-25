<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function searchProduct(string $name): Paginator
    {
        $product = '%' . str_replace(' ', '%', $name) . '%';

        $results = Product::select('*')
            ->where('name', 'like', $product)
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->simplePaginate(9);

        return $results;
    }

    public function insertProduct(array $data, int $userId)
    {
        $fileName = Storage::disk('public')->putFile('/product', $data["pfoto"]);

        if ($fileName !== false) {
            Product::insert([
                'name' => $data['nproduto'],
                'description' => $data['descricao'],
                'price' => $data['preco'],
                'stock' => $data['estoque'],
                'product_picture' => $fileName,
                'user_id' => $userId
            ]);
        }
    }

    public function productData(int $id)
    {
        return Product::select('*')
            ->where('id', $id)
            ->get()->toArray();
    }

    public function addToCard(int $id, int $userId)
    {
        Cart::insert([
            'user_id' => $userId,
            'product_id' => $id
        ]);
    }

    public function changeData(int $id, array $data)
    {
        Product::where('id', $id)
            ->update([
                'name' =>  $data["nproduto"],
                'description' => $data["descricao"],
                'price' => $data["preco"],
                'stock' => $data['estoque'],
            ]);
    }
}
