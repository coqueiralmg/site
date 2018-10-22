<?php

namespace App\Model\Table;

use Cake\ORM\Query;


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

        $this->belongsTo('AssuntoLegislacao', [
            'joinType' => 'INNER',
            'foreignKey' => 'id'
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

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['ativo' => true]);
    }

    public function findDestaque(Query $query, array $options)
    {
        return $query->where(['ativo' => true, 'destaque' => true]);
    }
}
