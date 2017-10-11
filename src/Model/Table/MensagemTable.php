<?php

namespace App\Model\Table;


class MensagemTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('mensagem');
        $this->primaryKey('id');
        $this->entityClass('Mensagem');

        $this->belongsTo('Usuario', [
            'className' => 'Usuario',
            'foreignKey' => 'destinatario',
            'propertyName' => 'destinatario',
            'joinType' => 'LEFT OUTER'
        ]);
    }
}