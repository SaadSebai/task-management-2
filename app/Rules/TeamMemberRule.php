<?php

namespace App\Rules;

use App\Models\Project;
use Illuminate\Contracts\Validation\Rule;

class TeamMemberRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private Project $project, private int $user_id)
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
        return $this->project
                    ->team
                    ->users()
                    ->where('users.id', $this->user_id)
                    ->exists();
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
