<?php

/**
 * Token Configuration
 */
return [
    'expire' => [

        // 30 minutes
        'accessToken' => env('ACCESS_TOKEN_EXPIRATION_SECONDS', 1800),

        // 4 weeks
        'refreshToken' => env('REFRESH_TOKEN_EXPIRATION_SECONDS', 2419200),

    ]
];
