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

        $results = $this->query->returnSql("SELECT * FROM produtos WHERE nome LIKE ? ORDER BY nome ASC LIMIT 6", [$product]);

        return $results;
    }
}
