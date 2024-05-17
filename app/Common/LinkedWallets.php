<?php

declare(strict_types=1);

namespace App\Common;

final class LinkedWallets
{
    public static function formatLinkedWalletCollection($linked_wallets): string
    {
        $outputs = '';
        foreach ($linked_wallets as $key => $value) {
            $outputs .= $key + 1 .'. '.data_get(target: $value, key: 'attributes.account_number').' - '.data_get(target: $value, key: 'attributes.scheme')."\n";
        }

        return $outputs;
    }

    public static function formatLinkedWalletForMenu($linked_wallets): string
    {
        $outputs = '';
        foreach ($linked_wallets as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'account_number')."\n";
        }

        return $outputs;
    }

    public static function formatLinkedWallets($linked_wallets): string
    {
        $outputs = '';
        foreach ($linked_wallets as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'wallet').' - '.data_get(target: $value, key: 'network')."\n";
        }

        return $outputs;
    }

    public static function formatLinkedWalletsInArray($linked_wallets): array
    {
        $outputs = [];
        foreach ($linked_wallets as $value) {
            $wallets = [
                'resource_id' => data_get(target: $value, key: 'attributes.resource_id'),
                'account_number' => data_get(target: $value, key: 'attributes.account_number'),
            ];
            $outputs[] = $wallets;
        }

        return $outputs;
    }
}
