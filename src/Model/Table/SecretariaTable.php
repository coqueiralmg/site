<?php

namespace App\Model\Table;

use Cake\ORM\Query;


class SecretariaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('secretaria');
        $this->primaryKey('id');
        $this->entityClass('Secretaria'); 
    }

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['ativo' => true]);
    }
}