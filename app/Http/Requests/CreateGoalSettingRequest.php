<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\GoalSettingDurationEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateGoalSettingRequest extends FormRequest
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
            'goal_plan' => ['required', 'string'],
            'goal_information' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'duration' => ['required', Rule::in(GoalSettingDurationEnum::toArray())],
        ];
    }
}
