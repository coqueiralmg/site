<?php

return [
    'Files' => [
        'validation' => [
            'document' => [
                'types' => ['pdf', 'doc', 'docx', 'odt', 'xls', 'xlsx', 'ods', 'zip'],
                'maxLength' => 102400
            ],
            'image' => [
                'types' => ['gif', 'jpg', 'jpeg', 'png'],
                'maxLength' => 5120
            ]
        ]
    ]
];
