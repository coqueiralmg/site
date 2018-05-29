<?php

namespace App\Model\Table;

class CargoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('documentos');
        $this->primaryKey('id');
        $this->entityClass('Cargo');

        $this->belongsTo('Concurso', [
            'className' => 'Concurso',
            'foreignKey' => 'concurso',
            'propertyName' => 'concurso',
            'joinType' => 'INNER'
        ]);
    }
}
