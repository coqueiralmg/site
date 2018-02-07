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
            Configure::read('Ouvidoria.status.definicoes.novo'),
            Configure::read('Ouvidoria.status.definicoes.aceito'),
        ];

        if(isset($manifestanteID))
        {
            return $query->where([
                'manifestante' => $manifestanteID,
                'status' => $status,
                'data <' => $data_minima
            ], ['status' => 'integer[]']);
        }
        else
        {
            return $query->where([
                'status' => $status,
                'data <' => $data_minima
            ], ['status' => 'integer[]']);
        }
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

    public function findAbertos(Query $query, array $options)
    {
        $manifestanteID = $options['manifestante'];

        $status = Configure::read('Ouvidoria.status.fechado');

        if(isset($manifestanteID))
        {
            return $query->where([
                'manifestante' => $manifestanteID,
                'status <>' => $status
            ]);
        }
        else
        {
            return $query->where([
                'status <>' => $status
            ]);
        }
    }

    public function findNovo(Query $query, array $options)
    {
        $manifestanteID = isset($options['manifestante']) ? $options['manifestante'] : 0;
        $status = Configure::read('Ouvidoria.status.definicoes.novo');
        return $this->buscaStatusManifestacao($query, $manifestanteID, $status);
    }

    public function findAceito(Query $query, array $options)
    {
        $manifestanteID = isset($options['manifestante']) ? $options['manifestante'] : 0;
        $status = Configure::read('Ouvidoria.status.definicoes.aceito');
        return $this->buscaStatusManifestacao($query, $manifestanteID, $status);
    }

    public function findRecusado(Query $query, array $options)
    {
        $manifestanteID = isset($options['manifestante']) ? $options['manifestante'] : 0;
        $status = Configure::read('Ouvidoria.status.definicoes.recusado');
        return $this->buscaStatusManifestacao($query, $manifestanteID, $status);
    }

    public function findAtendido(Query $query, array $options)
    {
        $manifestanteID = isset($options['manifestante']) ? $options['manifestante'] : 0;
        $status = Configure::read('Ouvidoria.status.definicoes.atendido');
        return $this->buscaStatusManifestacao($query, $manifestanteID, $status);
    }

    public function findAtividade(Query $query, array $options)
    {
        $manifestanteID = isset($options['manifestante']) ? $options['manifestante'] : 0;
        $status = Configure::read('Ouvidoria.status.definicoes.emAtividade');
        return $this->buscaStatusManifestacao($query, $manifestanteID, $status);
    }

    public function findConcluido(Query $query, array $options)
    {
        $manifestanteID = isset($options['manifestante']) ? $options['manifestante'] : 0;
        $status = Configure::read('Ouvidoria.status.definicoes.concluido');
        return $this->buscaStatusManifestacao($query, $manifestanteID, $status);
    }

    private function buscaStatusManifestacao(Query $query, int $manifestanteID, int $status)
    {
        if(isset($manifestanteID) && $manifestanteID > 0)
        {
            return $query->where([
                'manifestante' => $manifestanteID,
                'status' => $status
            ]);
        }
        else
        {
            return $query->where([
                'status' => $status
            ]);
        }
    }
}