<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function requestData(int $id): array
    {
        $user = User::select('*')
            ->where('id', $id)
            ->get()->toArray();

        $product = Product::select('*')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(4, ['*'], 'products');

        $purchases = Product::select('purchases.product_id', 'products.name')
            ->join('purchases', 'products.id', 'purchases.product_id')
            ->where('purchases.user_id', $id)
            ->orderBy('purchases.created_at', 'desc')
            ->paginate(4, ['*'], 'purchases');

        return [$user, $product, $purchases];
    }

    public function newPhoto($picture, int $userId): void
    {
        $fileName = Storage::disk('public')->putFile('/user', $picture);

        $actualPicture = User::select('user_picture')
            ->where('id', $userId)
            ->get()->toArray()[0]['user_picture'];

        if ($actualPicture !== null) {
            Storage::disk('public')->delete($actualPicture);
        }

        User::where('id', $userId)
            ->update([
                'user_picture' => $fileName
            ]);;
    }
}
