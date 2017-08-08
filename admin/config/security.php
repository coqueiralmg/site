<?php

return[
    /**
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'UHJlZmVpdHVyYSBNdW5pY2lwYWwgZGUgQ29xdWVpcmFsIC0gQW1vciBQb3IgTm9zc2EgR2VudGU='),
        'login' => [
            'attemps' => [
                'max' => 5,
                'warning' => 3
            ]
        ]
    ],
];