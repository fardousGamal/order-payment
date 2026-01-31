<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case PENDING = 'pending';
    case REFUNDED = 'refunded';
    case VOIDED = 'voided';

    case PARTIALLY_PAID = 'partially_paid';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return self::handleLabel($this->value);
    }
    public static function handleLabel($label): string
    {
        return str($label)->title()->headline();
    }

    public static function labels(): array
    {
        return array_reduce(self::cases(), function ($result, self $case) {
            $result[$case->value] = $case->label();
            return $result;
        }, []);
    }

    public static function color(self $status): string
    {
        return match($status) {
            self::PENDING => 'primary',
            self::PAID => 'success',
            self::REFUNDED => 'info',
            self::VOIDED => 'danger',
            default => 'warning'
        };
    }
}
