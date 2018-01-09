<?php

namespace App\Model\Table;


class RemententeTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('usuario');
        $this->primaryKey('id');
        $this->entityClass('Usuario');

        $this->belongsTo('Pessoa', [
            'className' => 'Pessoa',
            'foreignKey' => 'pessoa',
            'propertyName' => 'pessoa',
            'joinType' => 'LEFT OUTER'
        ]);
    }
}