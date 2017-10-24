<?php

return[
    'Ouvidoria' => [
        'ativo' => true,
        'grupoOuvidor'=> 7,
        'status' => [
            'inicial' => 1,
            'fechado' => 6,
            'definicoes' => [
                'novo' => 1,
                'aceito' => 2,
                'atendido' => 3,
                'emAtividade' => 4,
                'concluido' => 5,
                'fechado' => 6,
                'recusado' => 7
            ]
        ],
        'prioridadeInicial' => 1,
        'prazo' => 10,
        'sendMail' => true
    ]    
];