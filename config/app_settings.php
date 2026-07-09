<?php

$publicName = env('APP_PUBLIC_NAME', env('APP_NAME', 'Rock Code Starter'));
$contactEmail = env('APP_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com'));
$contactName = env('APP_CONTACT_NAME', env('MAIL_FROM_NAME', $publicName));

return [
    'public_name' => $publicName,

    'contact' => [
        'name' => $contactName,
        'email' => $contactEmail,
        'phone' => env('APP_CONTACT_PHONE'),
        'url' => env('APP_CONTACT_URL'),
    ],

    'seo' => [
        'default_title' => env('APP_SEO_DEFAULT_TITLE', env('SEO_DEFAULT_TITLE', $publicName)),
        'title_suffix' => env('APP_SEO_TITLE_SUFFIX', env('SEO_TITLE_SUFFIX', ' | '.$publicName)),
        'default_description' => env('APP_SEO_DEFAULT_DESCRIPTION', env('SEO_DEFAULT_DESCRIPTION')),
        'default_image' => env('APP_SEO_DEFAULT_IMAGE', env('SEO_DEFAULT_IMAGE')),
        'twitter_card' => env('APP_SEO_TWITTER_CARD', env('SEO_TWITTER_CARD', 'summary_large_image')),
        'robots' => env('APP_SEO_ROBOTS', env('SEO_ROBOTS', 'index,follow')),
    ],

    'flags' => [
        'public_registration' => (bool) env('APP_FLAG_PUBLIC_REGISTRATION', true),
        'media_uploads' => (bool) env('APP_FLAG_MEDIA_UPLOADS', true),
        'growth_tracking' => (bool) env('GROWTH_ENABLED', false),
    ],
];
