<?php

namespace App\Model\Table;

use Cake\ORM\Query;

class CategoriaTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('categorias_perguntas');
        $this->primaryKey('id');
        $this->entityClass('Categoria');

        $this->hasMany('Pergunta', [
            'className' => 'Pergunta',
            'foreignKey' => 'categoria',
            'propertyName' => 'perguntas',
        ]);
    }

    public function findAtivo(Query $query, array $options)
    {
        return $query->where(['ativo' => true]);
    }
}
