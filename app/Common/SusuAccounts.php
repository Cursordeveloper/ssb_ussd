<?php

declare(strict_types=1);

namespace App\Common;

final class SusuAccounts
{
    public static function formatSusuAccountsForOutput($susu_accounts): string
    {
        $outputs = '';
        foreach ($susu_accounts as $key => $value) {
            $outputs .= $key + 1 .'. '.data_get(target: $value, key: 'attributes.account_name')."\n";
        }

        return $outputs;
    }

    public static function formatSusuAccountsForMenu($susu_accounts): string
    {
        $outputs = '';
        foreach ($susu_accounts as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'susu_name')."\n";
        }

        return $outputs;
    }

    public static function formatSusuAccountsInArray($susu_collection): array
    {
        $outputs = [];

        foreach ($susu_collection as $value) {
            $susu = [
                'susu_resource' => data_get(target: $value, key: 'attributes.resource_id'),
                'susu_name' => data_get(target: $value, key: 'attributes.account_name'),
                'susu_scheme_code' => data_get(target: $value, key: 'attributes.scheme_code'),
            ];
            $outputs[] = $susu;
        }

        return $outputs;
    }
}
