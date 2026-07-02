<?php

return [
    'enabled' => filter_var(env('GROWTH_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
    'retention_days' => (int) env('GROWTH_RETENTION_DAYS', 365),
    'attribution_keys' => ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'],
    'metadata_limit' => 20,
    'metadata_string_limit' => 255,
    'blocked_metadata_keys' => [
        'content',
        'cpf',
        'cnpj',
        'document',
        'email',
        'hash',
        'input',
        'name',
        'output',
        'payload',
        'phone',
        'query',
        'text',
        'token',
        'url',
    ],
];
