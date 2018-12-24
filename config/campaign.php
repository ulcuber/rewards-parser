<?php

return [
    'base_uri' => 'https://tiltify.com/api/v3/campaigns/'.env('TILFIFY_CAMPAIGN_ID').'/',
    'headers' => [
        'Content-Type' => 'text/xml',
        'Authorization' => 'Bearer '.env('TILFIFY_TOKEN'),
    ]
];
