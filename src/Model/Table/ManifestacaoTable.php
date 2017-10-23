<?php

namespace App\Model\Table;


class ManifestacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('manifestacao');
        $this->primaryKey('id');
        $this->entityClass('Manifestacao');

        $this->belongsTo('Manifestante', [
            'className' => 'Manifestante',
            'foreignKey' => 'manifestante',
            'propertyName' => 'manifestante',
            'joinType' => 'INNER'
        ]);

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