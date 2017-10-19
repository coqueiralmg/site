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
    }
}