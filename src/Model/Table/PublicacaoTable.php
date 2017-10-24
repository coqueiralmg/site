<?php

namespace App\Model\Table;

use Cake\ORM\Query;


class PublicacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('publicacao');
        $this->primaryKey('id'); 
        $this->entityClass('Publicacao');       
    }

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['ativo' => true]);
    }
}