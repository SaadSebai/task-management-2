<?php

namespace App\Rules;

use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class NewTeamMemberRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private Team $team, private int $user_id)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return User::whereId($this->user_id)
                    ->whereHas(
                        'teams',
                        fn($query) => $query->where('teams.id', $this->team->id)
                    )
                    ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.exists', ['attribute' => 'user_id']);
    }
}
