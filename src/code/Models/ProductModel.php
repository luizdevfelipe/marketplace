<?php

declare(strict_types=1);

namespace Code\Models;

class ProductModel
{
    protected string $name = '!*****!';

    public function __construct(private Queries $query)
    {
        if (isset($_GET['produto']) && $_GET['produto'] != '') {
            $this->name = $_GET['produto'];
        }
    }

    public function searchProduct(): array
    {
        $product = '%' . str_replace(' ', '%', $this->name) . '%';

        $results = $this->query->returnSql("SELECT * FROM produtos WHERE nome LIKE ? ORDER BY nome ASC LIMIT 6", [$product], true);

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
                $this->query->simpleSql("INSERT INTO produtos (nome, descricao, preco, estoque, foto, vendedor) VALUES (?, ?, ?, ?, ?, ?)", [$nome, $desc, $preco, $estoque, $path, $_SESSION['id']]);
            } else {
                echo 'Erro ao salvar o arquivo!';
            }
        }
    }

    public function productData()
    {
        $id = $_SESSION['p_id'];
        return $this->query->returnSql("SELECT * FROM produtos WHERE id = ?", [$id]);
    }

    public function addToCard(int $id)
    {
        $this->query->simpleSql("INSERT INTO carrinho (iduser, idproduto) VALUES (?, ?)", [$_SESSION['id'], $id]);
    }

    public function changeData()
    {
        $this->query->simpleSql("UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ? WHERE id = ?", [$_POST["nproduto"], $_POST["descricao"], $_POST["preco"], $_POST['estoque'], $_SESSION['p_id']]);
        $sair = "window.location.href = 'http://localhost/marketplace/'";
    }
}
