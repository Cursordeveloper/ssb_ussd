<?php

declare(strict_types=1);

namespace App\States\NewCustomer\TermsAndConditions;

use App\Menus\NewCustomer\TermsAndConditionsMenu\TermsAndConditionsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        return match (true) {
            ! array_key_exists('tcsOne', $process_flow) => self::updateAndReturnMenu($session, 'tcsOne', TermsAndConditionsMenu::mainMenu(session: $session)),
            ! array_key_exists('tcsTwo', $process_flow) => self::updateAndReturnMenu($session, 'tcsTwo', TermsAndConditionsMenu::tcsOne(session: $session)),
            ! array_key_exists('tcsThree', $process_flow) => self::updateAndReturnMenu($session, 'tcsThree', TermsAndConditionsMenu::tcsTwo(session: $session)),
            ! array_key_exists('lastTcs', $process_flow) => self::updateAndReturnMenu($session, 'lastTcs', TermsAndConditionsMenu::tcsThree(session: $session)),
            ! array_key_exists('end', $process_flow) => self::updateAndReturnMenu($session, 'end', TermsAndConditionsMenu::lastTcs(session: $session)),
            default => TermsAndConditionsMenu::mainMenu(session: $session),
        };
    }

    private static function updateAndReturnMenu(Session $session, string $key, JsonResponse $menu): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::execute(session: $session, user_input: [$key => true]);

        // Return the menu (Term and Condition)
        return $menu;
    }
}
