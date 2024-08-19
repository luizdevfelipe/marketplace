<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\View\View;

class CartController
{
    public function __construct(private CartService $cardService)
    {
    }

    public function index()
    {
        if (empty($_SESSION['id'])) {
            return view('error/perfil');
        }

        $products = $this->cardService->getProducts();
        return view('user/carrinho', ['products' => $products]);
    }

    public function remove()
    {
        if (!empty($_GET['id'])) {
            $this->cardService->removeProduct();
        } else {
            return view('error/404');
        }
    }

    public function buy()
    {
        if ($this->cardService->getProductsId()) {
            $this->cardService->buyProducts();
        } 
    }
}