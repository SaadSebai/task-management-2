<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @param int $id
 * @param string $name
 * @param ?string $description
 * @param string $status
 * @param ?string $started_at
 * @param ?string $finished_at
 * @param ?int $team_id
 * @param ?int $creator_id
 * @param ?string $created_at
 * @param ?string $updated_at
 * @param ?Team $team
 * @param ?User $creator
 * @param Collection<int, Task> $tasks
 *
 * @method void filter()
 * @method void order()
 */
class Project extends Model
{
    use HasFactory, Sortable;

    const ORDER_ATTRIBUTES = [
        'id',
        'name',
        'status',
        'started_at',
        'finished_at',
        'team_id',
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
        'team_id',
        'creator_id',
    ];

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
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
            $filters['team_id'] ?? [],
            fn($q) => $q->whereTeamId($filters['Team'])
        );
    }
}
