<?php

namespace App\Enum;

enum TransactionStatus: String
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
