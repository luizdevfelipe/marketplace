<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;

class ProductController
{
    private ?int $userId;

    public function __construct(
        private ProductService $productService,
        private AuthManager $auth
    ) {
        $this->userId = $this->auth->id();
    }

    public function index(int $productId): Response|RedirectResponse
    {
        $produto = $this->productService->productData((int) $productId);

        if (!$produto) return redirect('/');

        if ($this->auth->check() && $this->userId == $produto[0]['user_id']) {
            return response()->view('products.productOwner', ['produto' => $produto]);
        }
        return response()->view('products.productView', ['produto' => $produto, 'id' => $productId]);
    }

    public function search(string $query): Response|RedirectResponse
    {
        if ($query) {
            $results = $this->productService->searchProduct($query);
            return response()->view('products.search', ['results' => $results]);
        }

        return redirect('/');
    }

    public function newProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required|min:4|max:30',
            'descricao' => 'bail|required|min:15|max:100',
            'preco' => 'bail|required|decimal:0,2',
            'estoque' => 'bail|required|integer',
            'pfoto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->productService->insertProduct($data, $this->userId);

        return redirect('/perfil');
    }

    public function buying(int $productId): RedirectResponse
    {
        $produto = $this->productService->productData((int) $productId);

        if (
            $this->auth->check()
            && $this->auth->user()->hasVerifiedEmail()
            && $this->userId !== $produto[0]['user_id']
        ) {
            $this->productService->addToCard($produto[0]['id'], $this->userId);
            return redirect('/carrinho');
        } else {
            return redirect('/login');
        }
    }

    public function chageData(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required',
            'descricao' => 'bail|required',
            'preco' => 'bail|required',
            'estoque' => 'bail|required',
        ]);

        if ($productId !== null && $this->productService->userHasProduct($this->userId, $productId)) {
            $this->productService->changeData($productId, $data);
        } else {
            return redirect('/');
        }

        return redirect('/produto/' . $productId);
    }
}
