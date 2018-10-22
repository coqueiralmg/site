<?php

namespace App\Model\Table;

class AssuntoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('assuntos');
        $this->primaryKey('id');

        $this->belongsToMany('Legislacao', [
            'joinTable' => 'assuntos_legislacao',
            'foreignKey' => 'assunto',
            'targetForeignKey' => 'legislacao',
            'propertyName' => 'legislacoes'
        ]);
    }
}
