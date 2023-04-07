<?php

return [
    'sandbox'          => env('DPD_SANDBOX', true),
    'base_url'         => [
        'sandbox'    => env('DPD_SHIPPER_BASE_URL_SANDBOX', 'https://shipperadmintest.dpd.nl/PublicAPI/WSDL/'),
        'production' => env('DPD_SHIPPER_BASE_URL_PRODUCTION', 'https://wsshipper.dpd.nl/soap/WSDL/'),
    ],
    'auth_url'         => env('DPD_AUTH_URL', 'http://dpd.com/common/service/types/Authentication/2.0'),
    'message_language' => env('DPD_MESSAGE_LANGUAGE', 'en_US'),
    'region_accounts'  => [
        'default' => [
            'id'       => env('DPD_ID'),
            'password' => env('DPD_PASSWORD'),
            'depot_nr' => env('DPD_DEPOT_NUMBER'),
        ],
    ],
];
