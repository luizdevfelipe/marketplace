<?php

namespace App\Enums\Payment;

enum MercadoPagoEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}