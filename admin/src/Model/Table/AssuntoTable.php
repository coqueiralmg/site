<?php

namespace App\Model\Table;

class AssuntoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('assuntos');
        $this->primaryKey('id');
    }
}
