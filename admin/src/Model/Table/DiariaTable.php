<?php

namespace App\Model\Table;

class DiariaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('diarias');
        $this->primaryKey('id');
        $this->entityClass('Diaria');
    }
}
