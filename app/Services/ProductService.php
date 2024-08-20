<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

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
        $nome = $_POST['nproduto'];
        $desc = $_POST['descricao'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];

        if (!empty($nome) && !empty($desc) && !empty($preco) && !empty($estoque) && isset($_FILES["pfoto"])) {
            $foto = $_FILES["pfoto"];
            $pasta = "storage/users/produtos/";

            if ($foto["error"]) {
                echo 'Erro ao enviar o arquivo!';
            }

            if ($foto["size"] > 2097152) {
                echo 'Arquivo máximo de 2Mb, tente novamente';
            }

            $nomeOriginal = $foto["name"];
            $nomeCodificado = uniqid();
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

            $path = $pasta . $nomeCodificado . '.' . $extensao;

            if ($extensao != 'jpg' && $extensao != 'png') {
                echo 'Arquivo não suportado!';
            }

            if (move_uploaded_file($foto["tmp_name"], $path)) {
                Product::insert([
                    'nome' => $nome,
                    'descricao' => $desc,
                    'preco' => $preco,
                    'estoque' => $estoque,
                    'foto' => $path,
                    'vendedor' => $_SESSION['id']
                ]);
            } else {
                echo 'Erro ao salvar o arquivo!';
            }
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
            'id_user' => $_SESSION['id'],
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