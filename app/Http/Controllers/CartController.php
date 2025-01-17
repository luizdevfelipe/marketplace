<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\MercadoPagoEnum;
use App\Enums\PaymentStatusEnum;
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
        if ($products = $this->cardService->getProducts(Auth::id())) {

            $preference = $this->mercadoPagoService->createPaymentPreference($products);

            if ($preference) {
                $this->cardService->createNewPurchase($preference->id, $products, Auth::id());
                return redirect($preference->sandbox_init_point);
            }
            
        }
        return response()->view('cart.error');
    }

    public function success(Request $request): Response
    {
        $status = $request->query('status');        
        $purchaseId = $request->query('preference_id');

        if ($status === MercadoPagoEnum::APPROVED->value && $purchaseId) {
            $this->cardService->buyProducts($purchaseId);
        }

        return response()->view('cart.success');
    }

    public function fail(): Response
    {
        return response()->view('cart.error');
    }
}
