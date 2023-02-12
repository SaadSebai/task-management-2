<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @param int $id
 * @param string $name
 * @param ?int $creator_id
 * @param ?string $created_at
 * @param ?string $updated_at
 * @param Collection<int, User> $users
 * @param ?User $user
 * @param Collection<int, Project> $projects
 *
 * @method void filter()
 * @method void order()
 */
class Team extends Model
{
    use HasFactory, Sortable;

    const ORDER_ATTRIBUTES = [
        'id',
        'name',
        'creator_id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'creator_id',
    ];

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
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
        );
    }
}
