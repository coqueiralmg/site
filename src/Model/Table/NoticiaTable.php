<?php

namespace App\Model\Table;


class NoticiaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('noticia');
        $this->primaryKey('id');

        $this->belongsTo('Post', [
            'className' => 'Post',
            'foreignKey' => 'post',
            'propertyName' => 'post',
            'joinType' => 'INNER'
        ]);
    }
}