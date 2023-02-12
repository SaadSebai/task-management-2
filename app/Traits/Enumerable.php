<?php

namespace App\Traits;

use Illuminate\Support\Arr;

/**
 * Gives the values of Enum as table
 */
trait Enumerable
{
    /**
     * return values of Enum
     *
     * @return array
     */
    public static function values(): array
    {
        return Arr::pluck(self::cases(), 'value');
    }
}
