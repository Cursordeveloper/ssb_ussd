<?php

declare(strict_types=1);

namespace App\Common;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\GoalGetterSusuAccountMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\GoalGetterSusuAccountState;
use Domain\Susu\BizSusu\Menus\Account\BizSusuAccountMenu;
use Domain\Susu\BizSusu\States\Account\BizSusuAccountState;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;

final class Helpers
{
    public static function formatPhoneNumber($phone_number): string
    {
        return substr_replace($phone_number, '0', 0, 3);
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

    public static function getSusuScheme(string $scheme_code): array
    {
        $scheme_codes = [
            'SSB-PSS001' => ['url' => 'personal-susus', 'state' => new PersonalSusuAccountState, 'menu' => new PersonalSusuAccountMenu],
            'SSB-BSS002' => ['url' => 'biz-susus', 'state' => new BizSusuAccountState, 'menu' => new BizSusuAccountMenu],
            'SSB-GGS003' => ['url' => 'goal-getter-susus', 'state' => new GoalGetterSusuAccountState, 'menu' => new GoalGetterSusuAccountMenu],
            'SSB-FSS004' => ['url' => 'flexy-susus', 'state' => new FlexySusuAccountState, 'menu' => new FlexySusuAccountMenu],
        ];

        return $scheme_codes[$scheme_code];
    }
}
