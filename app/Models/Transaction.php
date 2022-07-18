<?php

declare(strict_types = 1);

namespace App\Models;

use App\Exceptions\FileNotFoundException;
use App\Model;

class Transaction extends Model
{
    public function getFiles(string $dirPath): array
    {
        $files = [];

        foreach (\scandir($dirPath) as $file) {
            if (\is_dir($file)) {
                continue;
            }

            $files[] = $dirPath . $file;
        }

        return $files;
    }



    public function readTransactions(string $fileName): array
    {
        if (!file_exists($fileName)) {
            throw new FileNotFoundException();
        }

            if (\strstr($fileName, 'Jan_data.csv')){
            $file = fopen($fileName, 'r');

           

            fgetcsv($file);

            $transactions = [];

            while (($transaction = fgetcsv($file)) !== false) {
                $transactions[] = (new Transaction)->extractTransaction($transaction);
            }


            return $transactions;
        } else {
            $file = fopen($fileName, 'r');

            fgetcsv($file);

            $transactions = [];

            while (($transaction = fgetcsv($file)) !== false) {
                $transactions[] = (new Transaction)->extractTransaction1($transaction);
            }

            return $transactions;
        }
    }

    public function extractTransaction (array $transactionRow): array {
            [$date, $checkNumber, $description, $amount] = $transactionRow;

            $amount = (float)  str_replace(['$', ','], '', $amount);

            $date = date('M j, Y', strtotime(\str_replace('/', '-', $date)));

            return [
                'date'         => $date,
                'checkNumber'  => $checkNumber,
                'description'  => $description,
                'amount'       => $amount,
            ];
    }

    public function extractTransaction1(array $transactionRow): array
    {
        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $amount = (float)  str_replace(['$', ','], '', $amount);

        $date = date('M j, Y', strtotime($date));

        return [
            'date'         => $date,
            'checkNumber'  => $checkNumber,
            'description'  => $description,
            'amount'       => $amount,
        ];
    }

    public function calculateTotals(array $transactions): array
    {
        $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

        foreach ($transactions as $transaction) {
            $totals['netTotal'] += $transaction['amount'];

            if ($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }

        return $totals;
    }

}