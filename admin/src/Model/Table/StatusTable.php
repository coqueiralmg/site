<?php

namespace App\Model\Table;


class StatusTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('status');
        $this->primaryKey('id');
        $this->entityClass('Status');
    }
}