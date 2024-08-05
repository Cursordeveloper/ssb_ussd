<?php

declare(strict_types=1);

namespace App\Common;

final class Transactions
{
    public static function formatTransactionsForMenu(array $transactions): string
    {
        $outputs = '';
        foreach ($transactions as $value) {
            $outputs .= data_get(target: $value, key: 'attributes.transaction_date').' - '.data_get(target: $value, key: 'attributes.transaction_type').' - GHS'.data_get(target: $value, key: 'attributes.amount')."\n";
        }

        return $outputs;
    }
}
