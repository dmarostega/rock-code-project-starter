<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Administrators
    |--------------------------------------------------------------------------
    |
    | This starter intentionally keeps administration simple. Add the email
    | addresses allowed to access /admin as a comma-separated list in
    | ADMIN_EMAILS. Replace this rule with roles or permissions only when a
    | derived product has a concrete authorization model.
    |
    */
    'emails' => array_values(array_filter(array_map(
        static fn (string $email): string => mb_strtolower(trim($email)),
        explode(',', (string) env('ADMIN_EMAILS', '')),
    ))),
];
