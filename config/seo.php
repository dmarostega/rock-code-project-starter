<?php

return [
    'default_title' => env('APP_SEO_DEFAULT_TITLE', env('SEO_DEFAULT_TITLE', env('APP_PUBLIC_NAME', env('APP_NAME', 'Rock Code Starter')))),
    'title_suffix' => env('APP_SEO_TITLE_SUFFIX', env('SEO_TITLE_SUFFIX', ' | '.env('APP_PUBLIC_NAME', env('APP_NAME', 'Rock Code Starter')))),
    'default_description' => env('APP_SEO_DEFAULT_DESCRIPTION', env('SEO_DEFAULT_DESCRIPTION')),
    'default_image' => env('APP_SEO_DEFAULT_IMAGE', env('SEO_DEFAULT_IMAGE')),
    'twitter_card' => env('APP_SEO_TWITTER_CARD', env('SEO_TWITTER_CARD', 'summary_large_image')),
    'robots' => env('APP_SEO_ROBOTS', env('SEO_ROBOTS', 'index,follow')),
];
