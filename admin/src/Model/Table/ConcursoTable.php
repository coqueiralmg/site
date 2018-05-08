<?php

namespace App\Model\Table;

class ConcursoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('concursos');
        $this->primaryKey('id');
        $this->entityClass('Concurso');
    }
}
