<?php

return [
    'enabled' => (bool) env('GROWTH_ENABLED', true),
    'retention_days' => (int) env('GROWTH_RETENTION_DAYS', 365),
    'attribution_keys' => ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'],
    'metadata_limit' => 20,
];
