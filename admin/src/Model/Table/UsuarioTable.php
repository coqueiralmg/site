<?php

namespace App\Model\Table;


class UsuarioTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('usuario');
        $this->primaryKey('id');

        $this->belongsTo('Pessoa', [
            'className' => 'Pessoa',
            'foreignKey' => 'pessoa',
            'propertyName' => 'pessoa',
            'joinType' => 'INNER'
        ]);

    }
}