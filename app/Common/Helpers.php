<?php

declare(strict_types=1);

namespace App\Common;

final class Helpers
{
    public static function Phone($phone_number): string
    {
        return substr_replace($phone_number, '0', 0, 3);
    }

    public static function GetLinkedAccountNumbers($linked_wallets): string
    {
        $outputs = '';
        foreach ($linked_wallets as $key => $value) {
            $outputs .= $key + 1 .'. '.data_get(target: $value, key: 'attributes.account_number').' - '.data_get(target: $value, key: 'attributes.scheme')."\n";
        }

        return $outputs;
    }
}
