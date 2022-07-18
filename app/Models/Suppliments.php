<?php

declare(strict_types = 1);

namespace App\Models;

use DateTime;

class Suppliments
{
    public function formatDollarAmount(float $amount): string
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

    public function formatDate(array $transactionRow): array
    {
        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $date = date('M j, Y', strtotime(\str_replace('/', '-', $date)));

        return [
            'date'         => $date,
            'checkNumber'  => $checkNumber,
            'description'  => $description,
            'amount'       => $amount,
        ];
    }

    public function formatDate1(array $transactionRow): array
    {
        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $date = date('M j, Y', strtotime($date));

        return [
            'date'         => $date,
            'checkNumber'  => $checkNumber,
            'description'  => $description,
            'amount'       => $amount,
        ];
    }
}