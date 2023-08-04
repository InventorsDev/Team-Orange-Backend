<?php

namespace App\Http\Requests;

use App\Rules\EnumValue;
use Illuminate\Validation\Rule;
use App\Enums\GoalSettingDurationEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalSettingRequest extends FormRequest
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
            'goal_plan' => ['sometimes', 'string'],
            'goal_information' => ['sometimes', 'string'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date', 'after_or_equal:start_date'],
            'duration' => ['sometimes', Rule::in(GoalSettingDurationEnum::toArray())],
        ];
    }
}