<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'     => ['required', 'string', 'email', 'max:255'],
            'password'  => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Check if the Token is generated.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(?string $token)
    {
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
    }
}
