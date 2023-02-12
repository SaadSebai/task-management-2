<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @param int $id
 * @param string $name
 * @param ?string $description
 * @param ?string $started_at
 * @param ?string $finished_at
 * @param int $project_id
 * @param ?int $user_d
 * @param ?int $creator_id
 * @param ?string $created_at
 * @param ?string $updated_at
 * @param Project $project
 * @param ?User $user
 * @param ?User $creator
 *
 * @method void filter()
 * @method void order()
 */
class Task extends Model
{
    use HasFactory, Sortable;

    const ORDER_ATTRIBUTES = [
        'id',
        'name',
        'status',
        'started_at',
        'finished_at',
        'project_id',
        'user_id',
        'creator_id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'started_at',
        'finished_at',
        'project_id',
        'creator_id',
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Filter resources.
     *
     * @param  Builder  $query
     * @param  array  $filters
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters = []): void
    {
        $query->when(
            $filters['search'] ?? [],
            fn($q) => $q->where('name', 'ILIKE', "%{$filters['search']}%")
        )
            ->when(
                $filters['status'] ?? [],
                fn($q) => $q->whereStatus($filters['status'])
            )
            ->when(
                $filters['project_id'] ?? [],
                fn($q) => $q->whereTeamId($filters['Team'])
            );
    }
}
