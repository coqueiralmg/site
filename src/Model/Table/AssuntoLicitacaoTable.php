<?php

namespace App\Model\Table;

class AssuntoLicitacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('assunto_licitacao');
        $this->primaryKey('id');
    }
}
