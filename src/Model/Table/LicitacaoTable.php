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
    }

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['ativo' => true]);
    }

    public function findNovo(Query $query, array $options)
    {
        return $query->where(['ativo' => true, 'antigo' => false]);
    }

    public function findAntigo(Query $query, array $options)
    {
        return $query->where(['ativo' => true, 'antigo' => true]);
    }

    public function findDestaque(Query $query, array $options)
    {
        return $query->where(['ativo' => true, 'destaque' => true, 'antigo' => false]);
    }
}
