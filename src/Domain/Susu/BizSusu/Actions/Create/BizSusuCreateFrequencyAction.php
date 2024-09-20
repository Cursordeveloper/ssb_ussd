<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateFrequencyAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the frequencies from the $session->user_data
        $frequencies = json_decode($session->user_data, associative: true)['frequencies'];

        // Validate the user_input (susu_amount)
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $frequencies) => GeneralMenu::invalidFrequencyMenu(session: $session),

            default => self::frequencyStore(session: $session, service_data: $service_data, frequencies: $frequencies)
        };
    }

    public static function frequencyStore(Session $session, $service_data, $frequencies): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $frequencies[$service_data->user_input]['code']]);

        // Return the initialDepositMenu
        return GeneralMenu::linkedWalletMenu(session: $session);
    }
}
