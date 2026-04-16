<?php

return [

    // Prevent embedded x-frames
    'x-frame-options' => 'DENY',

    // Blocks MIME type sniffing to prevent MIME confusion attacks
    'x-content-type-options' => 'nosniff',

    // Forces the sending of all referrer information, improving compatibility
    'referrer-policy' => 'strict-origin-when-cross-origin',

    // Force the use of HTTPS
    'strict-transport-security' => [
        'max-age' => 63072000,
        'include-sub-domains' => true,
        'preload' => true,
    ],

    // Isolates the browsing context to same-origin documents.
    'cross-origin-opener-policy' => 'same-origin',

    // Requires authorisation for cross-origin embedded resources
    'cross-origin-embedder-policy' => 'require-corp',

    // Disables access, to geolocation, the camera, and the microphone
    // Disables FLoC
    'permissions-policy' => [
        'geolocation' => [],
        'camera' => [],
        'microphone' => [],
        'interest-cohort' => [],
    ],

    // Allow crawlers
    'x-robots-tag' => 'index, follow',
];