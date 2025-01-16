<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\MercadoPagoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController
{
    public function __construct(
        private CartService $cardService,
        private MercadoPagoService $mercadoPagoService,
    ) {}

    public function index(): Response|RedirectResponse
    {
        $products = $this->cardService->getProducts(Auth::id());
        return response()->view('cart.index', ['products' => $products]);
    }

    public function remove(int $id): RedirectResponse
    {
        if (!empty($id)) $this->cardService->removeProduct((int) $id);

        return redirect('/carrinho');
    }

    public function generatePayment(): Response|RedirectResponse
    {
        if ($ids = $this->cardService->getProducts(Auth::id())) {
            
                        $preference = $this->mercadoPagoService->createPaymentPreference();

            return redirect($preference->sandbox_init_point);
        }
        return response()->view('cart.error');
    }

    public function success(): Response
    {
        return response()->view('cart.success');
    }

    public function fail(): Response
    {
        return response()->view('cart.error');
    }
}
