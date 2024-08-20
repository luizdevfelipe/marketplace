<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response as HttpResponse;

class HomeController
{
    /**
     * Show the profile for a given user.
     */
    public function index(): HttpResponse
    {
        $result = Product::select('*')
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->limit(6)
            ->get()->toArray(); 

            return response()->view('index', ['rows' => $result]);        
    }
}