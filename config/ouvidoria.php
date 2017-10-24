<?php

return[
    'Ouvidoria' => [
        'ativo' => true,
        'grupoOuvidor'=> 7,
        'prazo' => 10,
        'sendMail' => true,
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
        'prioridade' => [
            'inicial' => 1,
            'definicoes' => [
                'baixa' => [
                    'id' => 2,
                    'nivel' => 0
                ],
                'normal' => [
                    'id' => 1,
                    'nivel' => 1
                ],
                'alta' => [
                    'id' => 3,
                    'nivel' => 2
                ],
                'urgente' => [
                    'id' => 4,
                    'nivel' => 3
                ]
            ]
        ]
    ]    
];