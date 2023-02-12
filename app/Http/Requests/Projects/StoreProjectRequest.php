<?php

namespace App\Http\Requests\Projects;

use App\Enums\ProjectStatuses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProjectRequest extends FormRequest
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
            'status'        => ['required', 'string', new Enum(ProjectStatuses::class)],
            'started_at'    => ['nullable', 'date'],
            'finished_at'   => ['nullable', 'date'],
            'team_id'       => ['nullable', 'bail', 'integer', 'exists:teams,id'],
        ];
    }
}
