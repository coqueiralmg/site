<?php

namespace App\Model\Table;

class CategoriaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('categorias_perguntas');
        $this->primaryKey('id');
    }
}
