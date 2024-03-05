<?php 
namespace Code\Controller;

use Code\Models\ProductModel;
use Code\View;

class ProductController
{
    public function __construct(private ProductModel $productModel)
    {        
    }

    public function index()
    {
        return View::make('products/product');
    }

    public function search()
    {
        $results = $this->productModel->searchProduct();
        return View::make('products/search', ['results' => $results]);
    }


}