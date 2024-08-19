<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\View\View;

class ProductController
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index()
    {
        $_SESSION['p_id'] = $_GET['id'];
        $produto = $this->productService->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] == $produto[0]['vendedor']) {
            return View('products/productOwner', ['produto' => $produto]);
        }
        return View('products/productView', ['produto' => $produto]);
    }

    public function search()
    {
        $results = $this->productService->searchProduct();
        return View('products/search', ['results' => $results]);
    }

    public function newProduct()
    {
        $this->productService->insertProduct();
        header('Location: /perfil');
    }

    public function buying()
    {
        $produto = $this->productService->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] != $produto[0]['vendedor']) {
            $this->productService->addToCard($produto[0]['id']);
            header('Location: /carrinho');
        } else {
            header('Location: /login');
        }
    }

    public function chageData()
    {
        if (isset($_POST['nproduto']) && isset($_SESSION['p_id'])) {
            $this->productService->changeData();
        }
        header('Location: /produto?id=' . $_SESSION['p_id']);
    }
}