<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function requestData(): array
    {
        $user = User::select('*')
            ->where('id', session()->get('id'))
            ->get()->toArray();

        $product = Product::select('*')
            ->where('user_id', session()->get('id'))
            ->get()->toArray();

        $purchases = Product::select('purchases.product_id', 'products.name')
            ->join('purchases', 'products.id', 'purchases.product_id')
            ->where('purchases.user_id', session()->get('id'))
            ->get()->toArray();

        return [$user, $product, $purchases];
    }

    public function newPhoto($picture)
    {
        $fileName = Storage::disk('public')->putFile('/user', $picture);

        User::where('id', session()->get('id'))
            ->update([
                'user_picture' => $fileName
            ]);;
    }
}
