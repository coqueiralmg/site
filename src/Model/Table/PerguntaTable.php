<?php

namespace App\Model\Table;

class PerguntaTable extends BaseTable
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

        $this->belongsToMany('PerguntaRelacionada', [
            'joinTable' => 'perguntas_relacionamento',
            'foreignKey' => 'pergunta_origem',
            'targetForeignKey' => 'pergunta_relacionada ',
            'propertyName' => 'relacionadas'
        ]);
    }
}
