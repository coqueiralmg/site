<?php

namespace App\Model\Table;


class PerguntaRelacionadaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('pergunta');
        $this->primaryKey('id');
        $this->entityClass('Pergunta');
    }
}
