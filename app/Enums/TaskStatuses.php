<?php

namespace App\Enums;

use App\Traits\Enumerable;

enum TaskStatuses: string
{
    use Enumerable;

    case TO_DO          = 'to do';
    case IN_PROGRESS    = 'in progress';
    case ON_HOLD         = 'on hold';
    case IN_TEST        = 'in test';
    case DONE           = 'done';
    case CANCELED       = 'canceled';
}
