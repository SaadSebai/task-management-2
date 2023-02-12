<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * Get the identifier that will be stored in the subject claim of the JWT.
    *
    * @return mixed
    */
   public function getJWTIdentifier(): mixed
   {
       return $this->getKey();
   }

   /**
    * Return a key value array, containing any custom claims to be added to the JWT.
    *
    * @return array
    */
   public function getJWTCustomClaims(): array
   {
       return [];
   }

   /**
    * Undocumented function
    *
    * @return HasMany
    */
   public function ownedTeams(): HasMany
   {
        return $this->hasMany(Team::class);
   }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function ownedProjects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function ownedTasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

   /**
    * @return BelongsToMany
    */
   public function teams(): BelongsToMany
   {
       return $this->belongsToMany(Team::class);
   }

    /**
     * @return HasMany
     */
   public function tasks(): HasMany
   {
       return $this->hasMany(Task::class);
   }
}
