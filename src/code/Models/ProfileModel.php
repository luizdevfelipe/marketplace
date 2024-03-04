<?php

declare(strict_types=1);

namespace Code\Models;

class ProfileModel
{
    protected $id;

    public function __construct(private Queries $query)
    {
        $this->id = $_SESSION['id'];
    }

    public function requestData(): array
    {
        $user = $this->query->returnSql("SELECT * FROM usuarios WHERE id = ?", [$this->id]);

        $product = $this->query->returnSql("SELECT * FROM produtos WHERE vendedor = ?", [$this->id]);

        $purchases = $this->query->returnSql("SELECT c.idproduto, p.nome FROM produtos p JOIN compras c ON p.id = c.idproduto WHERE c.iduser = ?", [$this->id]);

        return [$user, $product, $purchases];
    }
}
