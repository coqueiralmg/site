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
