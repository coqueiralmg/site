<?php

namespace App\Model\Table;


class PerguntaRelacionadaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('perguntas');
        $this->primaryKey('id');
        $this->entityClass('Pergunta');

        $this->belongsTo('Categoria', [
            'className' => 'Categoria',
            'foreignKey' => 'categoria',
            'propertyName' => 'categoria',
            'joinType' => 'INNER'
        ]);
    }
}
