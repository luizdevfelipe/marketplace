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

    public function productData()
    {
        $id = $_SESSION['p_id'];
        return Product::select('*')
            ->where('id', $id)
            ->get()->toArray();
    }

    public function addToCard(int $id)
    {
        Cart::insert([
            'id_user' => session()->get('id'),
            'product_id' => $id
        ]);
    }

    public function changeData()
    {
        Product::where('id', $_SESSION['p_id'])
            ->update([
                'name' =>  $_POST["nproduto"],
                'description' => $_POST["descricao"],
                'price' => $_POST["preco"],
                'stock' => $_POST['estoque'],
            ]);
       header('location: /');
    }
}