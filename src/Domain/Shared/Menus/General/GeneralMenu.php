<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\Common\GetSusuDurationsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GeneralMenu
{
    public static function terminateService(string $session_id): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Service is temporally unavailable. You will be notified soon.',
            session_id: $session_id,
        );
    }

    public static function invalidInput(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'There was a problem with your request. Try again later',
            session_id: $session->session_id,
        );
    }

    public static function infoNotification(Session $session, string $message): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: $message,
            session_id: $session->session_id,
        );
    }

    public static function terminateSession(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'Thank you for using SusuBox. See you soon.',
            session_id: $session->session_id,
        );
    }

    public static function systemErrorNotification(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'An unexpected error occurred while processing your request. Please try again later',
            session_id: $session->session_id,
        );
    }

    public static function requestNotification(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'Your request is being processed. You will receive a notification to confirm status',
            session_id: $session->session_id,
        );
    }

    public static function createAccountNotification(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'Your account is being processed. You will receive a notification to confirm status',
            session_id: $session->session_id,
        );
    }

    public static function paymentNotificationMenu(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'Your payment is being processed. You will receive a notification to confirm status',
            session_id: $session->session_id,
        );
    }

    public static function processTerminatedMenu(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'The process has been successfully terminated. You can start again at any time',
            session_id: $session->session_id,
        );
    }

    public static function processCancelNotification(Session $session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'The process has been successfully canceled. You can start again at any time',
            session_id: $session->session_id,
        );
    }

    public static function susuAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter susu amount',
            session_id: $session->session_id,
        );
    }

    public static function initialDepositMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Start with (amount)',
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu(Session $session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function startDateMenu(Session $session): JsonResponse
    {
        // Get the durations from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Start from\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidStartDateMenu(Session $session): JsonResponse
    {
        // Get the start_dates from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidFrequencyMenu(Session $session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid option, try again\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function durationMenu(Session $session): JsonResponse
    {
        // Execute the GetSusuDurationsAction and return the data
        (new GetSusuDurationsAction)::execute(session: $session);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n".SusuResources::formatDurationsForMenu(durations: $session->userData()['durations']),
            session_id: $session->session_id,
        );
    }

    public static function invalidDurationMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid duration\n".SusuResources::formatDurationsForMenu(durations: $session->userData()['durations']),
            session_id: $session->session_id,
        );
    }

    public static function pinLengthMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The PIN length is invalid. Please correct your input and try again.',
            session_id: $session->session_id,
        );
    }

    public static function pinMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Enter SusuBox PIN code to confirm or 2 to cancel\n",
            session_id: $session->session_id,
        );
    }

    public static function incorrectPinMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The PIN you entered is incorrect. Enter the correct PIN to confirm or 2 to Cancel',
            session_id: $session->session_id,
        );
    }

    public static function linkedWalletMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $session->userData()['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function invalidLinkedWalletMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $session->userData()['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function acceptedSusuTermsMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://thesusubox.com/policies/susu\nAccept Terms & Conditions?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }

    public static function invalidAcceptedSusuTerms(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\nhttps://thesusubox.com/policies/susu\nAccept Terms & Conditions?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }

    public static function rollOverDebitMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Rollover debit?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }

    public static function invalidRollOverDebitMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\nRollover debit?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }
}
