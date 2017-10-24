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
}