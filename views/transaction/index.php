<?php

use App\Models\Suppliments;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1><a href="/">Home</a> </h1>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)) : ?>
                <?php foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?= $transaction['date']?></td>
                        <td><?= $transaction['chequenumber'] ?></td>
                        <td><?= $transaction['description'] ?></td>
                        <td> <?php if ($transaction['amount'] < 0) : ?>
                                <span style="color: red;">
                                    <?= (new Suppliments)->formatDollarAmount($transaction['amount']) ?>
                                </span>
                            <?php elseif ($transaction['amount'] > 0) : ?>
                                <span style="color: green;">
                                    <?= (new Suppliments)->formatDollarAmount($transaction['amount']) ?>
                                </span>
                            <?php else : ?> <?= (new Suppliments)->formatDollarAmount($transaction['amount']) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td>
                    <?= (new Suppliments)->formatDollarAmount($totals['totalIncome']) ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td>
                    <?= (new Suppliments)->formatDollarAmount($totals['totalExpense']) ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td>
                    <?= (new Suppliments)->formatDollarAmount($totals['netTotal']) ?>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>