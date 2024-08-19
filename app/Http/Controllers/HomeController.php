<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
 
class HomeController
{
    /**
     * Show the profile for a given user.
     */
    public function index(): View
    {
        $result = Product::select('*')
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->limit(6)
            ->get()->toArray(); 

        return view('index', [
            'rows' => $result
        ]);
    }
}