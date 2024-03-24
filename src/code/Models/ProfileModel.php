<?php

declare(strict_types=1);

namespace Code\Models;

class ProfileModel
{
    public function __construct(private Queries $query)
    {
    }

    public function requestData(): array
    {
        $user = $this->query->returnSql("SELECT * FROM usuarios WHERE id = ?", [$_SESSION['id']]);

        $product = $this->query->returnSql("SELECT * FROM produtos WHERE vendedor = ?", [$_SESSION['id']] , true);

        $purchases = $this->query->returnSql("SELECT c.idproduto, p.nome FROM produtos p JOIN compras c ON p.id = c.idproduto WHERE c.iduser = ?", [$_SESSION['id']], true);

        return [$user, $product, $purchases];
    }
}
