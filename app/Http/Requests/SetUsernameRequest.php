<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUsernameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'username' => 'required|string|max:50|min:3|unique:users,username'
        ];
    }
}
