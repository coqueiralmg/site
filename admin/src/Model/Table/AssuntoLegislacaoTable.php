<?php

namespace App\Model\Table;

class AssuntoLegislacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('assuntos_legislacao');
        $this->primaryKey('id');
    }
}
