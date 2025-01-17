<?php

namespace App\Enums;

enum MercadoPagoEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}