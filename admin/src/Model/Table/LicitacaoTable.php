<?php

namespace App\Model\Table;


class LicitacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('licitacao');
        $this->primaryKey('id');
        $this->entityClass('Licitacao');

        $this->belongsTo('Modalidade', [
            'className' => 'Modalidade',
            'foreignKey' => 'modalidade',
            'propertyName' => 'modalidade',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('StatusLicitacao', [
            'className' => 'StatusLicitacao',
            'foreignKey' => 'status',
            'propertyName' => 'status',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Assunto', [
            'joinTable' => 'assunto_licitacao',
            'foreignKey' => 'licitacao',
            'targetForeignKey' => 'assunto',
            'propertyName' => 'assuntos'
        ]);

        $this->belongsTo('AssuntoLicitacao', [
            'joinType' => 'INNER',
            'foreignKey' => 'id',
            'bindingKey' => 'licitacao',
        ]);
    }
}
