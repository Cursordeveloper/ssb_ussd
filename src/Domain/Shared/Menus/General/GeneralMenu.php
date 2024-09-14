<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GeneralMenu
{
    public static function invalidInput($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "There was a problem with your request. Try again later.\n",
            session_id: $session->session_id,
        );
    }

    public static function infoNotification($session, string $message): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: $message,
            session_id: $session->session_id,
        );
    }

    public static function terminateSession($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::terminateSession(
            session_id: $session->session_id,
        );
    }

    public static function systemErrorNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "An unexpected error occurred while processing your request. Please try again later.\n",
            session_id: $session->session_id,
        );
    }

    public static function requestNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "Your request is being processed. You will receive a notification to confirm status.\n",
            session_id: $session->session_id,
        );
    }

    public static function createAccountNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "Your account is being processed. You will receive a notification to confirm status.\n",
            session_id: $session->session_id,
        );
    }

    public static function paymentNotificationMenu($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "Your payment is being processed. You will receive a notification to confirm status.\n",
            session_id: $session->session_id,
        );
    }

    public static function processTerminatedMenu($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "The process has been successfully terminated. You can start again at any time.\n",
            session_id: $session->session_id,
        );
    }

    public static function processCancelNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "The process has been successfully canceled. You can start again at any time.\n",
            session_id: $session->session_id,
        );
    }

    public static function susuAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter susu amount',
            session_id: $session->session_id,
        );
    }

    public static function initialDepositMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Start with (amount)',
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function startDateMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Start from\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidStartDateMenu($session): JsonResponse
    {
        // Get the start_dates from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidFrequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid option, try again\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function durationMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $durations = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function invalidDurationMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $durations = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function incorrectPinMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Incorrect PIN\nThe PIN you entered is incorrect. Enter the correct PIN to confirm or 2 to Cancel.\n",
            session_id: $session->session_id,
        );
    }

    public static function linkedWalletMenu($session): JsonResponse
    {
        // Get the linked_wallets from the session->user_data
        $linked_wallets = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $linked_wallets['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function invalidLinkedWalletMenu($session): JsonResponse
    {
        // Get the linked_wallets from the session->user_data
        $linked_wallets = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $linked_wallets['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function acceptedSusuTermsMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://thesusubox.com/policies/susu\nAccept Terms & Conditions?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }

    public static function invalidAcceptedSusuTerms($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\nhttps://thesusubox.com/policies/susu\nAccept Terms & Conditions?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }

    public static function rollOverDebitMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Rollover debit?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }

    public static function invalidRollOverDebitMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\nRollover debit?\n1. Yes\n2. no",
            session_id: $session->session_id,
        );
    }
}
