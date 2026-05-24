<?php

namespace App\Filament\Support;

class PaymentStatus
{
    public const NO_BILLING = 'no_billing';

    public const UNPAID = 'unpaid';

    public const PARTIAL = 'partial';

    public const PAID = 'paid';

    public const VOID = 'void';

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            self::NO_BILLING => 'No invoice',
            self::UNPAID => 'Not paid',
            self::PARTIAL => 'Partially paid',
            self::PAID => 'Paid',
            self::VOID => 'Void',
        ];
    }

    public static function label(string $status): string
    {
        return self::labels()[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    public static function color(string $status): string
    {
        return match ($status) {
            self::PAID => 'success',
            self::PARTIAL => 'warning',
            self::UNPAID => 'danger',
            self::VOID => 'gray',
            default => 'gray',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function billingLabels(): array
    {
        return [
            self::UNPAID => 'Not paid',
            self::PARTIAL => 'Partially paid',
            self::PAID => 'Paid in full',
            self::VOID => 'Void',
        ];
    }
}
