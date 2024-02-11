<?php 
namespace Code\Controller;

use Code\View;

class ProductController
{
    public function index()
    {
        return View::make('products/product');
    }
}