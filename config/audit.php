<?php

return [
    'retention_days' => (int) env('AUDIT_RETENTION_DAYS', 365),

    'actions' => [
        'admin.accessed',
        'admin.configuration.updated',
        'media.deleted',
        'user.deleted',
        'user.role.changed',
    ],
];
