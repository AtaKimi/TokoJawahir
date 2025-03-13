<?php

namespace App\Enum;

enum BuyBackStatus: String
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
