<?php

return [
    'disk' => env('MEDIA_DISK', 'public'),
    'directory' => env('MEDIA_DIRECTORY', 'media'),
    'max_size_kb' => (int) env('MEDIA_MAX_SIZE_KB', 10240),
    'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'],
    'image' => [
        'max_width' => (int) env('MEDIA_IMAGE_MAX_WIDTH', 2400),
        'quality' => (int) env('MEDIA_IMAGE_QUALITY', 82),
        'format' => 'webp',
    ],
];
