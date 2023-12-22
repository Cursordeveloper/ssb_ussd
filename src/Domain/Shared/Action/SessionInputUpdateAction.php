<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;

final class SessionInputUpdateAction
{
    public static function execute(Session $session, array $user_input): void
    {
        $user_inputs = json_decode(json: $session['user_inputs'], associative: true);
        $session->update(['user_inputs' => json_encode(array_merge($user_inputs, $user_input))]);
    }

    public static function data(Session $session, array $user_data): void
    {
        $data = json_decode(json: $session['user_data'], associative: true);
        $session->update(['user_data' => json_encode(array_merge($data, $user_data))]);
    }

    public static function reset(Session $session): void
    {
        $session->update(attributes: ['user_inputs' => json_encode([])]);
    }
}
