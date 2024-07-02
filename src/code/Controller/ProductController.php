<?php

namespace Code\Controller;

use Code\Attributes\Get;
use Code\Attributes\Post;

use Code\Service\ProductService;
use Code\View;

class ProductController
{
    public function __construct(private ProductService $productService)
    {
    }

    #[Get('/produto')]
    public function index()
    {
        $_SESSION['p_id'] = $_GET['id'];
        $produto = $this->productService->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] == $produto[0]['vendedor']) {
            return View::make('products/productOwner', ['produto' => $produto]);
        }
        return View::make('products/productView', ['produto' => $produto]);
    }

    #[Get('/pesquisa')]
    public function search()
    {
        $results = $this->productService->searchProduct();
        return View::make('products/search', ['results' => $results]);
    }

    #[Post('/novoproduto')]
    public function newProduct()
    {
        $this->productService->insertProduct();
        header('Location: /perfil');
    }

    #[Post('/produto')]
    public function buying()
    {
        $produto = $this->productService->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] != $produto[0]['vendedor']) {
            $this->productService->addToCard($produto[0]['id']);
            header('Location: /carrinho');
        }
        header('Location: /login');
    }

    #[Post('/alteraproduto')]
    public function chageData()
    {
        if (isset($_POST['nproduto']) && isset($_SESSION['p_id'])) {
            $this->productService->changeData();
        }
        header('Location: /produto?id=' . $_SESSION['p_id']);
    }
}
