<?php

namespace App\Model\Table;


class SecretariaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('secretaria');
        $this->primaryKey('id');
        $this->entityClass('Secretaria'); 
    }
}