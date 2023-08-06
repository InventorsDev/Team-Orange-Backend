<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self weekly()
 * @method static self monthly()
 * @method static self daily()
 * @method static self yearly()
 */
class GoalSettingDurationEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'daily' => 'Daily',
            'yearly' => 'Yearly',
        ];
    }

    public static function fromValue($value): self
    {
        return new static($value);
    }

    public static function getRandomValue(): string
    {
        $values = static::values();
        $randomValue = array_rand($values);

        return $randomValue;
    }
}
