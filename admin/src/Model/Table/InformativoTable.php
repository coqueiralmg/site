<?php

namespace App\Model\Table;

class InformativoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('informacoes');
        $this->primaryKey('id');
        $this->entityClass('Informativo');

        $this->belongsTo('Concurso', [
            'className' => 'Concurso',
            'foreignKey' => 'concurso',
            'propertyName' => 'concurso',
            'joinType' => 'INNER'
        ]);
    }
}
