<?php

namespace App\Model\Table;


class BloqueadoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('bloqueados');
        $this->primaryKey('id');
    }
}