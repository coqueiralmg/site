<?php

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;

class ManifestacaoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('manifestacao');
        $this->primaryKey('id');
        $this->entityClass('Manifestacao');

        $this->belongsTo('Manifestante', [
            'className' => 'Manifestante',
            'foreignKey' => 'manifestante',
            'propertyName' => 'manifestante',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Prioridade', [
            'className' => 'Prioridade',
            'foreignKey' => 'prioridade',
            'propertyName' => 'prioridade',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Status', [
            'className' => 'Status',
            'foreignKey' => 'status',
            'propertyName' => 'status',
            'joinType' => 'INNER'
        ]);
    }

    public function findEnviados(Query $query, array $options)
    {
        $manifestanteID = $options['manifestante'];
        return $query->where(['manifestante' => $manifestanteID]);
    }

    public function findRespondidos(Query $query, array $options)
    {
        $manifestanteID = $options['manifestante'];
        $status = [
            Configure::read('Ouvidoria.status.definicoes.atendido'),
            Configure::read('Ouvidoria.status.definicoes.emAtividade'),
            Configure::read('Ouvidoria.status.definicoes.concluido')
        ];

        return $query->where([
            'manifestante' => $manifestanteID,
            'status' => $status,
            
        ], ['status' => 'integer[]']);
    }

    public function findAtrasados(Query $query, array $options)
    {
        $manifestanteID = $options['manifestante'];

        $prazo = Configure::read('Ouvidoria.prazo');
        $chave_prazo = "-$prazo days";
        $data_minima = date('Y-m-d H:i:s', strtotime($chave_prazo));

        $status = [
            Configure::read('Ouvidoria.status.definicoes.fechado'),
            Configure::read('Ouvidoria.status.definicoes.recusado'),
        ];

        return $query->where([
            'manifestante' => $manifestanteID,
            'status NOT IN' => $status,
            'data <' => $data_minima
        ]);
    }

    public function findFechados(Query $query, array $options)
    {
        $manifestanteID = $options['manifestante'];
        $status = Configure::read('Ouvidoria.status.fechado');

        return $query->where([
            'manifestante' => $manifestanteID,
            'status' => $status
        ]);
    }
}