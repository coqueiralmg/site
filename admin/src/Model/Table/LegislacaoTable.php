<?php

namespace App\Model\Table;


class LegislacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('legislacao');
        $this->primaryKey('id');
    }
}
