<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

class OuvidoriaController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_prioridade = TableRegistry::get('Prioridade');
        $t_status = TableRegistry::get('Status');

        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $status = $this->request->query('status');
            $prioridade = $this->request->query('prioridade');

            if ($data_inicial != "" && $data_final != "") 
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if ($status != '') 
            {
                $condicoes["status"] = $status;
            }

            if ($prioridade != '') 
            {
                $condicoes["prioridade"] = $prioridade;
            }

            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['status'] = $status;
            $data['prioridade'] = $prioridade;

            $this->request->data = $data;
        }

        $this->paginate = [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'Prioridade.nivel' => 'DESC',
                'data' => 'ASC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'publicações',
            'name_singular' => 'publicação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $manifestacoes = $this->paginate($t_manifestacao);

        $qtd_total = $t_manifestacao->find('all', [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'conditions' => $condicoes
        ])->count();

        $combo_status = $t_status->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        
        $combo_prioridade = $t_prioridade->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'nivel' => 'ASC'
            ]
        ]);

        $this->set('title', 'Ouvidoria');
        $this->set('icon', 'hearing');
        $this->set('manifestacoes', $manifestacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('combo_status', $combo_status);
        $this->set('combo_prioridade', $combo_prioridade);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        
    }
}