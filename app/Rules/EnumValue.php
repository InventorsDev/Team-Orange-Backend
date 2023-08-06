<?php

namespace App\Rules;

use Illuminate\Validation\Rule;

class EnumValue implements Rule
{
    protected $enumClass;

    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;
    }

    public function passes($attribute, $value)
    {
        return forward_static_call([$this->enumClass, 'isValid'], $value);
    }

    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}
