<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'full_name' => 'filled|string|max:100|min:3',
            'date_of_birth' => 'nullable',
            'gender' => 'nullable',
            'phone_number' => 'nullable|string|max:15|min:11',
            'country_id' => 'nullable|exists:countries,id',
            'profile_image_url' => 'nullable|image|mimes:png,jpg,gif',
        ];
    }
}
