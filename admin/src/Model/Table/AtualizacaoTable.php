<?php

namespace App\Model\Table;

class AtualizacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('informacao_licitacoes');
        $this->primaryKey('id');
        $this->entityClass('Atualizacao');

        $this->belongsTo('Licitacao', [
            'className' => 'Licitacao',
            'foreignKey' => 'licitacao',
            'propertyName' => 'licitacao',
            'joinType' => 'INNER'
        ]);
    }
}
