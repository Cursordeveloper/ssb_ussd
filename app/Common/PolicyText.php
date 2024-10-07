<?php

declare(strict_types=1);

namespace App\Common;

use Domain\Shared\Models\Policy\Policy;
use Domain\Shared\Models\Policy\PolicyContent;
use Domain\Shared\Models\Session\Session;

final class PolicyText
{
    public static function getPolicyUrl(string $policy): string
    {
        return Policy::where('code', $policy)->value('url');
    }

    public static function aboutSusuBox(Session $session): ?string
    {
        return PolicyContent::query()->where(column: 'policy_id', operator: '=', value: 1)->skip(value: (int) $session->userInputs()['page'])->take(value: 1)->value(column: 'text');
    }
}
