<?php

namespace App\Model\Table;

class AssuntoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('assuntos');
        $this->primaryKey('id');

        $this->belongsToMany('Assunto', [
            'joinTable' => 'funcoes_grupos',
            'foreignKey' => 'assunto',
            'targetForeignKey' => 'legislacao',
            'propertyName' => 'itens'
        ]);
    }
}
