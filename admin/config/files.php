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
            'files' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'editor' . DS . 'files' . DS,
            'public' => ROOT . DS . '..' . DS . 'webroot' . DS,
            'legislacao' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'legislacao-arquivo' . DS,
            'publicacao' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'publicacao-arquivo' . DS,
            'licitacoes' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'licitacao-edital' . DS,
            'diarias' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'relatorios-diaria' . DS,
            'noticias' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'noticia-foto' . DS . 'large' . DS,
            'concursos' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'storage' . DS . 'concurso-documento' . DS,
            'bannerHome' => ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'slides' . DS . 'home' . DS
        ],
        'urls' => [
            'editor' => '/public/editor/images/',
            'files' => '/public/editor/files/',
            'legislacao' => 'public/storage/legislacao-arquivo/',
            'publicacao' => 'public/storage/publicacao-arquivo/',
            'licitacoes' => 'public/storage/licitacao-edital/',
            'diarias' => 'public/storage/relatorios-diaria/',
            'noticias' => 'public/storage/noticia-foto/large/',
            'concursos' => 'public/storage/concurso-documento/',
            'bannerHome' => 'public/slides/home/'
        ]
    ]
];
