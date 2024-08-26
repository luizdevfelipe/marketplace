<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController
{
    public function __construct(private CartService $cardService)
    {
    }

    public function index(): Response|RedirectResponse
    {
        if (!session()->has('id')) {
            return redirect('/login');
        }
        $products = $this->cardService->getProducts();
        return response()->view('user.cart', ['products' => $products]);
    }

    public function remove(Request $request): Response
    {
        $id = $request->input('id');

        if (!empty($id)) {
            $this->cardService->removeProduct($id);
        } else {
            return response()->view('error.404');
        }
    }

    public function buy(): Response
    {
        if ($this->cardService->getProductsId()) {
            $this->cardService->buyProducts();
        } 
        return response()->view('user.cart');
    }
}