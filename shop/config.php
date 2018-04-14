<?php
/**
 * Configuration settings used by all of the examples.
 *
 * Specify your eBay application keys in the appropriate places.
 *
 * Be careful not to commit this file into an SCM repository.
 * You risk exposing your eBay application keys to more people than intended.
 */
return [
    'sandbox' => [
        'credentials' => [
            'devId' => 'SBX-7879bc6bf046-cada-4b74-8b7d-cbd6',
            'appId' => 'CalebHam-SHAIDSto-SBX-27879bc6b-3f7680ae',
            'certId' => 'abd155e5-8fce-43f2-b303-fb718882add8',
        ],
        'authToken' => 'YOUR_SANDBOX_USER_TOKEN_APPLICATION_KEY',
        'oauthUserToken' => 'YOUR_SANDBOX_OAUTH_USER_TOKEN',
        'ruName' => 'YOUR_SANDBOX_RUNAME'
    ],
    'production' => [
        'credentials' => [
            'devId' => 'PRD-787d01078b28-4d38-4bef-84ab-c4d4',
            'appId' => 'CalebHam-SHAIDSto-PRD-2787d0107-02f8ef26',
            'certId' => 'abd155e5-8fce-43f2-b303-fb718882add8',
        ],
        'authToken' => 'YOUR_PRODUCTION_USER_TOKEN_APPLICATION_KEY',
        'oauthUserToken' => 'YOUR_PRODUCTION_OAUTH_USER_TOKEN',
        'ruName' => 'YOUR_PRODUCTION_RUNAME'
    ]
];
