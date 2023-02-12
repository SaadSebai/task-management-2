<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    /**
     * Order resources.
     *
     * @param Builder $query
     * @param string|null $sort_attribute
     * @param string|null $sort_order
     * @return void
     */
    public function scopeOrder(Builder $query, ?string $sort_attribute = null, ?string $sort_order = null): void
    {
        $query->when(
            $sort_attribute && $sort_order,
            fn($q) => $q->orderBy($sort_attribute, $sort_order)
        );
    }
}
