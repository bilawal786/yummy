<?php

return [
    'name' => 'YummyBox',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'YummyBox',
        'start_url' => '/',
        'background_color' => 'transparent',
        'theme_color' => 'transparent',
        'display' => 'standalone',
        'orientation'=> 'portrait',
        'status_bar'=> 'black',
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'icons' => [
            '48x48' => [
                'path' => '/android/android-launchericon-48-48.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/android/android-launchericon-96-96.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/android/android-launchericon-192-192.png',
                'purpose' => 'any'
            ],
        ],
        'custom' => []
    ]
];
