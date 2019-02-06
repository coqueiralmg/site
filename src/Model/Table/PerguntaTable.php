<?php

namespace App\Model\Table;

use Cake\ORM\Query;

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

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['ativo' => true]);
    }

    public function findDestaque(Query $query, array $options)
    {
        return $query->where(['ativo' => true, 'destaque' => true]);
    }
}
