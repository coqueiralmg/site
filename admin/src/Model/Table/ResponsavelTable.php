<?php

namespace App\Model\Table;


class ResponsavelTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('pessoa');
        $this->primaryKey('id');
    }
}
