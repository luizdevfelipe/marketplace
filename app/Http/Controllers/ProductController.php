<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class ProductController
{
    public function __construct(private ProductService $productService) {}

    public function index(int $productId): Response|RedirectResponse
    {
        $produto = $this->productService->productData((int) $productId);

        if (!$produto) return redirect('/');

        if (Auth::check() && Auth::id() == $produto[0]['user_id']) {
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

        $this->productService->insertProduct($data, Auth::id());

        return redirect('/perfil');
    }

    public function buying(int $productId): RedirectResponse
    {
        $produto = $this->productService->productData((int) $productId);

        if (Auth::check() && Auth::user()->hasVerifiedEmail() && Auth::id() !== $produto[0]['user_id']) {
            $this->productService->addToCard($produto[0]['id'], Auth::id());
            return redirect('/carrinho');
        } else {
            return redirect('/login');
        }
    }

    public function chageData(Request $request, int $requestId): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required',
            'descricao' => 'bail|required',
            'preco' => 'bail|required',
            'estoque' => 'bail|required',
        ]);

        if ($requestId !== null) {
            $this->productService->changeData($requestId, $data);
        }
        return redirect('/produto/' . $requestId);
    }
}
