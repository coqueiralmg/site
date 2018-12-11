<?php

namespace App\Model\Table;

use Cake\ORM\Query;


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

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['Licitacao.ativo' => true]);
    }

    public function findNovo(Query $query, array $options)
    {
        return $query->where(['Licitacao.ativo' => true, 'Licitacao.antigo' => false]);
    }

    public function findAntigo(Query $query, array $options)
    {
        return $query->where(['Licitacao.ativo' => true, 'Licitacao.antigo' => true]);
    }

    public function findDestaque(Query $query, array $options)
    {
        return $query->where(['Licitacao.ativo' => true, 'Licitacao.destaque' => true, 'Licitacao.antigo' => false]);
    }
}
