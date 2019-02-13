<?php

namespace App\Model\Table;


class FeriadoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('feriados');
        $this->primaryKey('id');
        $this->entityClass('Feriado');
    }
}