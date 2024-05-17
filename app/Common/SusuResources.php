<?php

declare(strict_types=1);

namespace App\Common;

final class SusuResources
{
    public static function formatDurationsInArray($durations): array
    {
        $outputs = [];
        foreach ($durations as $value) {
            $data = [
                'name' => data_get(target: $value, key: 'attributes.name'),
                'code' => data_get(target: $value, key: 'attributes.code'),
                'days' => data_get(target: $value, key: 'attributes.days'),
            ];
            $outputs[] = $data;
        }

        return $outputs;
    }

    public static function formatDurationsForMenu($durations): string
    {
        $outputs = '';
        foreach ($durations as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'name')."\n";
        }

        return $outputs;
    }

    public static function formatStartDatesInArray($start_dates): array
    {
        $outputs = [];
        foreach ($start_dates as $value) {
            $data = [
                'name' => data_get(target: $value, key: 'attributes.name'),
                'code' => data_get(target: $value, key: 'attributes.code'),
                'days' => data_get(target: $value, key: 'attributes.days'),
            ];
            $outputs[] = $data;
        }

        return $outputs;
    }

    public static function formatStartDatesForMenu($start_dates): string
    {
        $outputs = '';
        foreach ($start_dates as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'name')."\n";
        }

        return $outputs;
    }

    public static function formatFrequenciesInArray($start_dates): array
    {
        $outputs = [];
        foreach ($start_dates as $value) {
            $data = [
                'name' => data_get(target: $value, key: 'attributes.name'),
                'code' => data_get(target: $value, key: 'attributes.code'),
            ];
            $outputs[] = $data;
        }

        return $outputs;
    }

    public static function formatFrequenciesForMenu($start_dates): string
    {
        $outputs = '';
        foreach ($start_dates as $key => $value) {
            $outputs .= $key.'. '.data_get(target: $value, key: 'name')."\n";
        }

        return $outputs;
    }
}
