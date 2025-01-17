<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
}