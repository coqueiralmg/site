<?php

return[
    'Ouvidoria' => [
        'grupoOuvidor'=> 7,
        'prazo' => 10,
        'tipos' => [
            'GR' => 'Geral',
            'IP' => 'Iluminação Pública',
            'LX' => 'Lixo, Entulho e Limpeza Urbana'
        ],
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
            'inicial' => 2,
            'definicoes' => [
                'baixa' => [
                    'id' => 1,
                    'nivel' => 0
                ],
                'normal' => [
                    'id' => 2,
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
