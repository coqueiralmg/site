<?php

namespace App\Model\Table;


class TipoLegislacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('tipo_legislacao');
        $this->primaryKey('id');
        $this->entityClass('Status');
    }
}
