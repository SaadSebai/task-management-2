<?php

namespace App\Enums;

use App\Traits\Enumerable;

enum ProjectStatuses: string
{
    use Enumerable;

    case TO_DO          = 'to do';
    case IN_PROGRESS    = 'in progress';
    case DONE           = 'done';
    case CANCELED       = 'canceled';
}

