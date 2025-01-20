<?php

use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Purchase;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('purchases:delete', function() {
    Purchase::where('created_at', '<=', now()->subDays(1))
        ->where('status', PaymentStatusEnum::PENDING->value)
        ->delete();
})->purpose('Delete pending purchases older than 1 day')->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
