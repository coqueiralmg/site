<?php

namespace App\Model\Table;


class ModalidadeTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('modalidade');
        $this->primaryKey('id');
        $this->entityClass('Modalidade');
    }
}
