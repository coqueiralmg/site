<?php

namespace App\Model\Table;

class PerguntaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('perguntas');
        $this->primaryKey('id');
    }
}
