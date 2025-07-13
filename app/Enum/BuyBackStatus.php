<?php

namespace App\Enum;

enum BuyBackStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
