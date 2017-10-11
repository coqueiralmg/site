<?php

namespace App\Model\Table;


class PrioridadeTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('prioridade');
        $this->primaryKey('id');
        $this->entityClass('Prioridade');
    }
}