<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class HomeController
{
    /**
     * Show some products on the home page.
     */
    public function index(): Response
    {
        $result = Product::select('*')
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->limit(6)
            ->get()->toArray();

        return response()->view('index', ['rows' => $result]);
    }    
}
