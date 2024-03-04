<?php 
namespace Code\Controller;

use Code\Models\ProductModel;
use Code\Models\Queries;
use Code\View;

class ProductController
{
    public function index()
    {
        return View::make('products/product');
    }

    public function search()
    {
        $results = (new ProductModel(new Queries))->searchProduct();
        return View::make('products/search', ['results' => $results]);
    }


}