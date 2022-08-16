<?php

declare(strict_types = 1);

namespace App\Enums;

use App\Enums\Color;

class InvoiceStatus
{
    const Pending = 0;
    const Paid    = 1;
    const Void    = 2;
    const Failed  = 3;

    public function toString(): string
    {
        return match($this) {
            self::Paid =>   'Paid',
            self::Failed => 'Declined',
            self::Void =>   'Void',
            default =>      'Pending',
        };
    }
}
