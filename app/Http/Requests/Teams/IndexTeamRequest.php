<?php

namespace App\Http\Requests\Teams;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexTeamRequest extends FormRequest
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
            'sort_attribute'    => ['nullable', 'string', Rule::in(Team::ORDER_ATTRIBUTES), 'max:255'],
            'sort_order'        => ['nullable', 'string', 'in:asc,desc', 'max:4'],
        ];
    }
}
