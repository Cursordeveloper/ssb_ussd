<?php

declare(strict_types=1);

namespace App\Common;

final class Helpers
{
    public static function formatPhoneNumber($phone_number): string
    {
        return substr_replace($phone_number, '0', 0, 3);
    }

    public static function formatLinkedWallets($linked_wallets): string
    {
        $outputs = '';
        foreach ($linked_wallets as $key => $value) {
            $outputs .= $key + 1 .'. '.data_get(target: $value, key: 'attributes.account_number').' - '.data_get(target: $value, key: 'attributes.scheme')."\n";
        }

        return $outputs;
    }

    public static function formatLinkedWalletsInArray($linked_wallets): array
    {
        $outputs = [];
        foreach ($linked_wallets as $value) {
            $wallets = ['wallet_resource' => data_get(target: $value, key: 'attributes.resource_id'), 'wallet' => data_get(target: $value, key: 'attributes.account_number'), 'network' => data_get(target: $value, key: 'attributes.scheme')];
            $outputs[] = $wallets;
        }

        return $outputs;
    }

    public static function arrayIndex(array $array): array
    {
        $adjustedArray = [];

        foreach ($array as $index => $value) {
            $adjustedIndex = $index + 1;
            $adjustedArray[$adjustedIndex] = $value;
        }

        return $adjustedArray;
    }
}
