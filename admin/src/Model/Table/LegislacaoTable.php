<?php

namespace App\Model\Table;


class LegislacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('legislacao');
        $this->primaryKey('id');
        $this->entityClass('Legislacao');

        $this->belongsTo('TipoLegislacao', [
            'className' => 'TipoLegislacao',
            'foreignKey' => 'tipo',
            'propertyName' => 'tipo',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Assunto', [
            'joinTable' => 'assuntos_legislacao',
            'foreignKey' => 'legislacao',
            'targetForeignKey' => 'assunto',
            'propertyName' => 'assuntos'
        ]);

        $this->belongsToMany('LegislacaoRelacionada', [
            'joinTable' => 'legislacao_relacionamento',
            'foreignKey' => 'legislacao_origem',
            'targetForeignKey' => 'legislacao_relacionada ',
            'propertyName' => 'relacionadas'
        ]);
    }
}
