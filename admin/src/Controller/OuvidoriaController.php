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
            'limit' => $limite_paginacao,
        ];

        $config = [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'conditions' => $condicoes,
            'order' => [
                'nivel' => 'DESC',
                'data' => 'ASC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'manifestações',
            'name_singular' => 'manifestação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $query = $t_manifestacao->find('all', $config);
        $manifestacoes = $this->paginate($query);

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
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $condicoes = array();

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
        }

        $manifestacoes = $t_manifestacao->find('all', [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'conditions' => $condicoes,
            'order' => [
                'nivel' => 'DESC',
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $manifestacoes->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de usuários.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Manifestos da Ouvidoria');
        $this->set('manifestacoes', $manifestacoes);
        $this->set('qtd_total', $qtd_total);
    }

    public function refresh(string $mensagem)
    {
        $this->Flash->greatSuccess($mensagem);
        $this->redirect(['action' => 'index']);
    }
}