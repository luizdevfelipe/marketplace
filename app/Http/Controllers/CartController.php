<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\AppEnvironmentEnum;
use App\Enums\Payment\MercadoPagoEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Services\CartService;
use App\Services\MercadoPagoService;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController
{
    public function __construct(
        private CartService $cardService,
        private MercadoPagoService $mercadoPagoService,
        private Request $request,
        private AuthManager $auth
    ) {}

    public function index(): Response|RedirectResponse
    {
        $products = $this->cardService->getProducts($this->auth->id());
        return response()->view('cart.index', ['products' => $products]);
    }

    public function remove(int $id): RedirectResponse
    {
        if (!empty($id)) $this->cardService->removeProduct((int) $id);

        return redirect('/carrinho');
    }

    public function generatePayment(): Response|RedirectResponse|JsonResponse
    {
        $validatedData = $this->request->validate([
            'selectedProductsCartIds' => 'required|array',
        ]);

        $products = $this->cardService->getMultipleProductsByUserAndCartId(
            $validatedData['selectedProductsCartIds'],
            $this->auth->id()
        );

        if (empty($products)) {
            return redirect('/carrinho');
        }

        $preference = $this->mercadoPagoService->createPaymentPreference($products);

        if ($preference) {
            $this->cardService->createNewPurchase($preference->id, $products, $this->auth->id());

            if (config('app.env') === AppEnvironmentEnum::PRODUCTION->value) {
                return response()->json(['mercado_pago_url' => $preference->init_point]);
            }
            return response()->json(['mercado_pago_url' => $preference->sandbox_init_point]);
        }

        return response()->view('cart.error');
    }

    public function success(): Response
    {
        $status = $this->request->query('status');
        $purchaseId = $this->request->query('preference_id');

        if ($status === MercadoPagoEnum::APPROVED->value && $purchaseId) {
            $this->cardService->buyProducts($purchaseId);
        }

        return response()->view('cart.success');
    }

    public function fail(): Response
    {
        $purchaseId = $this->request->query('preference_id');

        if ($purchaseId) {
            $this->cardService->updatePurchaseStatus($purchaseId, PaymentStatusEnum::REJECTED);
        }

        return response()->view('cart.error');
    }
}
