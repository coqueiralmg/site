<?php

namespace App\Model\Table;


class ManifestanteTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('manifestante');
        $this->primaryKey('id');
        $this->entityClass('Manifestante');
    }
}