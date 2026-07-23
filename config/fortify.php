<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'lowercase_usernames' => true,
    'home' => '/dashboard',
    'prefix' => '',
    'middleware' => ['web'],
    'views' => false,
    'limiters' => ['login' => 'login', 'two-factor' => 'two-factor'],
    'features' => array_filter([
        config('app_settings.flags.public_registration') ? Features::registration() : null,
        Features::resetPasswords(),
    ]),
];
