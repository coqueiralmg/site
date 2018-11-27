<?php

namespace App\Model\Table;

class GrupoAnexoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('grupo_anexos');
        $this->primaryKey('id');
        $this->entityClass('GrupoAnexo');
    }
}
