<?php

namespace App\Http\Requests\Tasks;

use App\Enums\TaskStatuses;
use App\Rules\TeamMemberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'status'        => ['required', 'string', new Enum(TaskStatuses::class)],
            'started_at'    => ['nullable', 'date'],
            'finished_at'   => ['nullable', 'date'],
            'user_id'       => ['nullable', 'bail', 'integer', new TeamMemberRule($this->project, $this->user_id)],
        ];
    }
}
