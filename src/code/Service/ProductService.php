<?php

declare(strict_types=1);

namespace Code\Service;

use Code\Models\Carrinho;
use Code\Models\Produtos;

class ProductService
{
    protected $table = 'produtos';
    protected string $name = '!*****!';

    public function __construct()
    {
        if (isset($_GET['produto']) && $_GET['produto'] != '') {
            $this->name = $_GET['produto'];
        }
    }

    public function searchProduct(): array
    {
        $product = '%' . str_replace(' ', '%', $this->name) . '%';

        $results = Produtos::select('*')
            ->where('nome', 'like', $product)
            ->orderBy('nome', 'asc')
            ->limit(6)
            ->get()->toArray();

        return $results;
    }

    public function insertProduct()
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
                Produtos::insert([
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
        return Produtos::select('*')
            ->where('id', $id)
            ->get()->toArray();
    }

    public function addToCard(int $id)
    {
        Carrinho::insert([
            'iduser' => $_SESSION['id'],
            'idproduto' => $id
        ]);
    }

    public function changeData()
    {
        Produtos::where('id', $_SESSION['p_id'])
            ->update([
                'nome' =>  $_POST["nproduto"],
                'descricao' => $_POST["descricao"],
                'preco' => $_POST["preco"],
                'estoque' => $_POST['estoque'],
            ]);
       header('location: /');
    }
}
