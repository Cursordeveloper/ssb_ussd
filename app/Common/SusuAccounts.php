<?php

declare(strict_types=1);

namespace App\Common;

final class SusuAccounts
{
    public static function formatSusuAccountsForOutput($linked_wallets): string
    {
        $outputs = '';
        foreach ($linked_wallets as $key => $value) {
            $outputs .= $key + 1 .'. '.data_get(target: $value, key: 'attributes.account_name').' - '.data_get(target: $value, key: 'attributes.code')."\n";
        }

        return $outputs;
    }

    public static function formatSusuAccounts($susu_accounts): string
    {
        $outputs = '';
        foreach ($susu_accounts as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'account_name').' - '.data_get(target: $value, key: 'scheme')."\n";
        }

        return $outputs;
    }

    public static function formatSusuAccountsInArray($susu_collection): array
    {
        $outputs = [];
        foreach ($susu_collection as $value) {
            $susu = [
                'account_name' => data_get(target: $value, key: 'attributes.account_name'),
                'resource_id' => data_get(target: $value, key: 'attributes.resource_id'),
                'scheme' => data_get(target: $value, key: 'attributes.code'),
                'frequency' => data_get(target: $value, key: 'attributes.frequency'),
            ];
            $outputs[] = $susu;
        }

        return $outputs;
    }
}
