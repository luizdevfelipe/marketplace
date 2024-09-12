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
        $products = $this->cardService->getProducts();
        return response()->view('user.cart', ['products' => $products]);
    }

    public function remove(Request $request): RedirectResponse
    {
        $id = $request->input('id');

        if (!empty($id)) $this->cardService->removeProduct((int) $id);           
        
        return redirect('/carrinho');
    }

    public function buy(): RedirectResponse
    {
        if ($ids = $this->cardService->getProductsId()) $this->cardService->buyProducts($ids);
        
        return redirect('/carrinho');
    }
}