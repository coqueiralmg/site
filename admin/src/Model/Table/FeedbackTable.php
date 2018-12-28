<?php

namespace App\Model\Table;

class FeedbackTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('feedback');
        $this->primaryKey('id');
    }
}
