<?php

namespace App\Services\Hubtel;

use Illuminate\Http\Request;

class HubtelUssdService
{
    public bool $new_session;
    public string $service_code;
    public string $session_id;
    public string $msisdn;
    public string $sequence;
    public string $user_input;
    public string $network;

    public function __construct(Request $request)
    {
        $this->new_session = $this->checkSession(
            data_get(
                target: $request,
                key: 'Type',
            ));
        $this->service_code = data_get(
            target: $request,
            key: 'ServiceCode',
        );
        $this->session_id = data_get(
            target: $request,
            key: 'SessionId',
        );
        $this->msisdn = data_get(
            target: $request,
            key: 'Mobile',
        );
        $this->sequence = data_get(
            target: $request,
            key: 'Sequence',
        );
        $this->user_input = data_get(
            target: $request,
            key: 'Message',
        );
        $this->network = data_get(
            target: $request,
            key: 'Operator',
        );
    }

    private function checkSession(string $type): bool {
        return strtolower($type) === 'initiation';
    }
}
