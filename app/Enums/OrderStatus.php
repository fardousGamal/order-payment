<?php

namespace App\Enums;

enum OrderStatus: string
{

    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';


    public static function values(?array $cases = null): array
    {
        return array_column($cases ?? self::cases(), 'value');
    }

    public function label(): string
    {
        return self::handleLabel($this->value );
    }

    public static function handleLabel($label): string
    {
        return str($label)
            ->title()
            ->headline()
            ->ucfirst();
    }

    public static function labels(): array
    {
        return self::reduceLabels(self::cases());
    }

    public static function reduceLabels(array $cases)
    {
        return array_reduce($cases, function ($result, self $case) {
            $result[$case->value] = $case->label();
            return $result;
        }, []);
    }
}
