<?php

declare(strict_types=1);

namespace Code\Models;

class CardModel
{
    public function __construct(private Queries $query)
    {
    }

    public function getProducts()
    {
        return $this->query->returnSql("SELECT * FROM produtos p JOIN carrinho c ON p.id = c.idproduto WHERE c.iduser = ?", [$_SESSION['id']], true);
    }

    public function removeProduct()
    {
        if (isset($_GET['id'])) {
            $this->query->simpleSql("DELETE FROM carrinho WHERE id = ?", [$_GET['id']]);
            header('Location: /carrinho');
        } else {
            echo 'erro ao remover produto';
        }
    }
}
