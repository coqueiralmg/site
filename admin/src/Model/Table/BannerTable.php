<?php

namespace App\Model\Table;


class BannerTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('banner');
        $this->primaryKey('id');
        $this->entityClass('Banner');
    }
}