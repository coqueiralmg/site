<?php

namespace App\Model\Table;

class DocumentoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('documentos');
        $this->primaryKey('id');
        $this->entityClass('Documento');

        $this->belongsTo('Concurso', [
            'className' => 'Concurso',
            'foreignKey' => 'concurso',
            'propertyName' => 'concurso',
            'joinType' => 'INNER'
        ]);
    }
}
