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
    'features' => [Features::registration(), Features::resetPasswords()],
];
