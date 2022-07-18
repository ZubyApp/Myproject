<?php

declare(strict_types = 1);

namespace App\Models;

use App\Model;

class Database extends Model
{
    public function insert(string $date, string $checkNumber, string $description, float $amount)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO transaction_1 (date, chequenumber, description, amount)
                 VALUES (?, ?, ?, ?)'
        );

        $stmt->execute([$date, $checkNumber, $description, $amount]);

    }

    public function retrieve()
    {
        $stmt = $this->db->prepare(
            'SELECT date, chequenumber, description, amount
            FROM transaction_1'
        );

        $stmt->execute();

        $transaction = $stmt->fetchAll();

        return $transaction ? $transaction : [];
    }
}