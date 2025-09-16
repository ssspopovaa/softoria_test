<?php

namespace App\Enums;

enum PeriodEnum: string
{
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case THREE_MONTHS = '3months';
    case SIX_MONTHS = '6months';
    case YEAR = 'year';
    case TWO_YEARS = '2years';

    public function label(): string
    {
        return match($this) {
            self::DAY => 'Day',
            self::WEEK => 'Week',
            self::MONTH => 'Month',
            self::THREE_MONTHS => '3 Months',
            self::SIX_MONTHS => '6 Months',
            self::YEAR => 'Year',
            self::TWO_YEARS => '2 Years',
        };
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}
