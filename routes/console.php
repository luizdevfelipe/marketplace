<?php

use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('purchases:reject', function () {
    Purchase::where('created_at', '<=', now()->subDays(1))
        ->where('status', PaymentStatusEnum::PENDING->value)
        ->update([
            'status' => PaymentStatusEnum::REJECTED->value
        ]);
})->purpose('Reject pending purchases older than 1 day')->daily();

Artisan::command('products:reset-stock', function () {
    $rejectedPurchases = Purchase::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
        ->where('status', PaymentStatusEnum::REJECTED->value)
        ->where('quantity', '>', 0)
        ->groupBy('product_id')
        ->get();

    foreach ($rejectedPurchases as $purchase) {
        Product::where('id', $purchase->product_id)
            ->update(['stock' => DB::raw('stock + ' . $purchase->total_quantity)]);
    }

    Purchase::where('status', PaymentStatusEnum::REJECTED->value)
        ->where('quantity', '>', 0)
        ->update(['quantity' => 0]);
})->purpose('Reset inventory for rejected purchase products')->daily();

Artisan::command('purchases:delete', function () {
    Purchase::where('quantity', 0)
        ->where('status', PaymentStatusEnum::REJECTED->value)
        ->delete();
})->purpose('Delete rejected purchases daily')->daily();
