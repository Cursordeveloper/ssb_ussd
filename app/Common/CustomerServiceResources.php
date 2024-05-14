<?php

declare(strict_types=1);

namespace App\Common;

final class CustomerServiceResources
{
    public static function formatLinkedAccountSchemesInArray($linked_account_schemes): array
    {
        $outputs = [];
        foreach ($linked_account_schemes as $value) {
            $data = [
                'resource_id' => data_get(target: $value, key: 'attributes.resource_id'),
                'name' => data_get(target: $value, key: 'attributes.name'),
                'code' => data_get(target: $value, key: 'attributes.code'),
            ];
            $outputs[] = $data;
        }

        return $outputs;
    }

    public static function formatLinkedAccountSchemesForMenu($linked_account_schemes): string
    {
        $outputs = '';
        foreach ($linked_account_schemes as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'name')."\n";
        }

        return $outputs;
    }
}
