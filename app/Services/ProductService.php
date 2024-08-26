<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function searchProduct(string $name): array
    {
        $product = '%' . str_replace(' ', '%', $name) . '%';

        $results = Product::select('*')
            ->where('name', 'like', $product)
            ->orderBy('name', 'asc')
            ->limit(6)
            ->get()->toArray();

        return $results;
    }

    public function insertProduct(array $data)
    {
        $fileName = Storage::disk('public')->putFile('', $data["pfoto"]);        
       
        if($fileName !== false){
             Product::insert([
            'name' => $data['nproduto'],
            'description' => $data['descricao'],
            'price' => $data['preco'],
            'stock' => $data['estoque'],
            'product_picture' => $fileName,
            'user_id' => session()->get('id')
        ]);
        }       
    }

    public function productData(int $id)
    {
        return Product::select('*')
            ->where('id', $id)
            ->get()->toArray();
    }

    public function addToCard(int $id)
    {
        Cart::insert([
            'user_id' => session()->get('id'),
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