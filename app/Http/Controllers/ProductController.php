<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index(): Response
    {
        $_SESSION['p_id'] = $_GET['id'];
        $produto = $this->productService->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] == $produto[0]['vendedor']) {
            return response()->view('products.productOwner', ['produto' => $produto]);
        }
        return response()->view('products.productView', ['produto' => $produto]);
    }

    public function search(Request $request): Response
    {
        $validated = $request->validate([
            'produto' => 'required|alpha:ascii|max:60'
        ]);
        $results = $this->productService->searchProduct($validated['name']);
        
        return response()->view('products.search', ['produto' => $results]);
    }

    public function newProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required',
            'descricao' => 'bail|required',
            'preco' => 'bail|required',
            'estoque' => 'bail|required',            
            'pfoto' => 'bail|required',            
        ]);

        $this->productService->insertProduct($data);

        return redirect('/perfil');
    }

    public function buying(): RedirectResponse
    {
        $produto = $this->productService->productData();
        if (isset($_SESSION['id']) && $_SESSION['id'] != $produto[0]['vendedor']) {
            $this->productService->addToCard($produto[0]['id']);
            return redirect('/carrinho');
        } else {
            return redirect('/login');
        }
    }

    public function chageData(): RedirectResponse
    {
        if (isset($_POST['nproduto']) && isset($_SESSION['p_id'])) {
            $this->productService->changeData();
        }
        return redirect('/produto?id=' . $_SESSION['p_id']);
    }
}