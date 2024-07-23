<?php

return [
    'USER_STATUS' => [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
    ],
    'GENERAL_CONSTANTS' => [
        'S3_URL' => env('S3_URL','null'),
        'S3_PUBLIC_URL' => env('S3_PUBLIC_URL','null'),
        'PAGE_SIZE' => 10,
        'privacy_policy' => '#',
        'terms_condition' => '#',
        'app_share_message' => '',
    ],
    'STATE_SAVE' => true,
    'PRIVATE_CONSTANTS' => [
        'PRIVATE' => TRUE,
    ],
    'STATUS' => [
        'DRAFT' => 'DRAFT',
        'PUBLISHED' => 'PUBLISHED',
        'INACTIVE' => 'INACTIVE'
    ],
];
