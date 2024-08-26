<?php

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

    public function index(Request $request): Response
    {
        $id = $request->query('id');
        $produto = $this->productService->productData($id);

        if (session()->has('id') && session()->get('id') == $produto[0]['user_id']) {
            return response()->view('products.productOwner', ['produto' => $produto]);
        }
        return response()->view('products.productView', ['produto' => $produto, 'id' => $id]);
    }

    public function search(Request $request): Response
    {
        $validated = $request->validate([
            'produto' => 'required|alpha:ascii|max:60'
        ]);
        $results = $this->productService->searchProduct($validated['produto']);
        
        return response()->view('products.search', ['results' => $results]);
    }

    public function newProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nproduto' => 'bail|required',
            'descricao' => 'bail|required',
            'preco' => 'bail|required',
            'estoque' => 'bail|required',            
            'pfoto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->productService->insertProduct($data);

        return redirect('/perfil');
    }

    public function buying(Request $request): RedirectResponse
    {
        $produto = $this->productService->productData($request->query('id'));

        if (session()->has('id') && session()->get('id') !== $produto[0]['user_id']) {
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