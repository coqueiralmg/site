<?php

namespace App\Model\Table;


class HistoricoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('historico');
        $this->primaryKey('id');
        $this->entityClass('Historico');
    }
}