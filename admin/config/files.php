<?php

return [
    'Files' => [
        'validation' => [
            'document' => [
                'types' => ['pdf', 'doc', 'docx', 'odt', 'xls', 'xlsx', 'ods', 'zip'],
                'maxLength' => 31457280
            ],
            'image' => [
                'types' => ['gif', 'jpg', 'jpeg', 'png'],
                'maxLength' => 5242880
            ]
        ],
        'misc' => [
            'kbyte' => 1024,
            'megabyte' => 1048576,
            'gigabyte' => 1073741824,
            'terabyte' => 10995111627776
        ],
        'paths' => [
            'editor' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'editor' . DS . 'images' . DS,
            'publicacoes' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'legislacao-arquivo' . DS
        ],
        'urls' => [
            'editor' => '/public/editor/images/',
            'publicacoes' => 'public/storage/legislacao-arquivo/'
        ]
    ]
];
