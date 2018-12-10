<?php

namespace App\Model\Table;

class AnexoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('anexos');
        $this->primaryKey('id');
        $this->entityClass('Anexo');
    }
}
