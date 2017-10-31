<?php

namespace App\Model\Table;


class HistoricoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('historico');
        $this->primaryKey('id');
        $this->entityClass('Historico');

        $this->belongsTo('Prioridade', [
            'className' => 'Prioridade',
            'foreignKey' => 'prioridade',
            'propertyName' => 'prioridade',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Status', [
            'className' => 'Status',
            'foreignKey' => 'status',
            'propertyName' => 'status',
            'joinType' => 'INNER'
        ]);
    }
}