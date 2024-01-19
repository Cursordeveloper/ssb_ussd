<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\SusuTerms;

use App\Menus\ExistingCustomer\Susu\SusuTerms\SusuTermsMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuTermsAction
{
    public static function execute(Session $session, $session_data, $user_inputs): JsonResponse
    {
        // Validate inputs and update the session input
        return match (true) {
            ! array_key_exists('susu_terms_one', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'susu_terms_one', SusuTermsMenu::mainMenu(session: $session)),
            ! array_key_exists('susu_terms_two', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'susu_terms_two', SusuTermsMenu::susuTermsOne(session: $session)),
            ! array_key_exists('susu_terms_three', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'susu_terms_three', SusuTermsMenu::susuTermsTwo(session: $session)),
            ! array_key_exists('susu_terms_four', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'susu_terms_four', SusuTermsMenu::susuTermsThree(session: $session)),
            ! array_key_exists('end', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'end', SusuTermsMenu::lastSusuTerms(session: $session)),
            default => SusuTermsMenu::mainMenu(session: $session),
        };
    }
}
