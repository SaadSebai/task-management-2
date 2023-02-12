<?php

namespace App\Http\Requests\Projects;

use App\Enums\ProjectStatuses;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class IndexProjectRequest extends FormRequest
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
            'filters'           => ['nullable', 'array'],
            'filters.search'    => ['nullable', 'string', 'max:255'],
            'filters.status'    => ['nullable', 'string', new Enum(ProjectStatuses::class)],
            'filters.team_id'   => ['nullable', 'bail', 'integer', 'exists:teams,id'],
            'sort_attribute'    => ['nullable', 'string', Rule::in(Project::ORDER_ATTRIBUTES), 'max:255'],
            'sort_order'        => ['nullable', 'string', 'in:asc,desc', 'max:4'],
        ];
    }
}
