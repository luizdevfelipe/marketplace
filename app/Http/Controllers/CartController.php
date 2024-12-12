<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController
{
    public function __construct(private CartService $cardService) {}

    public function index(): Response|RedirectResponse
    {
        $products = $this->cardService->getProducts(Auth::id());
        return response()->view('cart.index', ['products' => $products]);
    }

    public function remove(Request $request, int $id): RedirectResponse
    {
        if (!empty($id)) $this->cardService->removeProduct((int) $id);

        return redirect('/carrinho');
    }

    public function buy(): Response|RedirectResponse
    {
        if ($ids = $this->cardService->getProductsId(Auth::id())) {
            $this->cardService->buyProducts($ids, Auth::id());
            return response()->view('cart.success');
        }
        return response()->view('cart.error');
    }
}
