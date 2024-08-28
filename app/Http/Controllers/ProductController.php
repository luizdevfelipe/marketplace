<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;

class ProductController
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index(Request $request): Response|RedirectResponse
    {
        $id = $request->query('id');
        $produto = $this->productService->productData((int) $id);

        if(!$produto) return redirect('/');

        if (session()->has('id') && session()->get('id') == $produto[0]['user_id']) {
            return response()->view('products.productOwner', ['produto' => $produto]);
        }
        return response()->view('products.productView', ['produto' => $produto, 'id' => $id]);
    }

    public function search(Request $request): Response
    {
        $validated = $request->validate([
            'produto' => 'required|max:60'
        ]);
        $results = $this->productService->searchProduct($validated['produto']);
        
        return response()->view('products.search', ['results' => $results]);
    }

    public function newProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required|min:4|max:30',
            'descricao' => 'bail|required|min:15|max:100',
            'preco' => 'bail|required|decimal:2',
            'estoque' => 'bail|required|integer',            
            'pfoto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->productService->insertProduct($data);

        return redirect('/perfil');
    }

    public function buying(Request $request): RedirectResponse
    {
        $produto = $this->productService->productData((int) $request->query('id'));

        if (session()->has('id') && session()->get('id') !== $produto[0]['user_id']) {
            $this->productService->addToCard($produto[0]['id']);
            return redirect('/carrinho');
        } else {
            return redirect('/login');
        }
    }

    public function chageData(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required',
            'descricao' => 'bail|required',
            'preco' => 'bail|required',
            'estoque' => 'bail|required',                       
        ]);

        $product_id = (int) $request->query('id');

        if ($product_id !== null) {
            $this->productService->changeData($product_id, $data);
        }
        return redirect('/produto?id=' . $product_id);
    }
}