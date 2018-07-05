<?php

namespace App\Model\Table;

class PublicacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('publicacoes');
        $this->primaryKey('id');
    }
}
