<?php

namespace App\Model\Table;


class StatusLicitacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('status_licitacao');
        $this->primaryKey('id');
        $this->entityClass('StatusLicitacao');
    }
}
