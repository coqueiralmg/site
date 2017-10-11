<?php

namespace App\Model\Table;


class ManifestacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('manifestacao');
        $this->primaryKey('id');
        $this->entityClass('Manifestacao');
    }
}