<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Database;
use App\Models\Suppliments;
use App\Models\Transaction;
use App\View;

class TransactionController
{
    public function saveTransaction()
    {
        $files = (new Transaction)->getFiles(\FILE_PATH);

        $transactions = [];

        foreach ($files as $file) {
            
            $fileLoad = (new Transaction)->readTransactions($file);

            $transactions = array_merge($transactions, $fileLoad);

            foreach ($transactions as $transaction) {
                (new Database)->insert($transaction['date'], $transaction['checkNumber'], $transaction['description'], $transaction['amount']);
            }
            }
           
        return View::make('index');
    }
    
    Public function viewTransactions()
    {
        
        $transactions = (new Database)->retrieve();

        $totals = (new Transaction)->calculateTotals($transactions);
        
        return View::make('transaction/index', ['transactions' => $transactions,'totals' => $totals]);
    }
}