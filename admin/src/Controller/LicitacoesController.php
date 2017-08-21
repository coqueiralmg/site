<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;
use \DateTime;


class LicitacoesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $limite_paginacao = Configure::read('Pagination.limit');
        
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3) 
        {
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($data_inicial != "" && $data_final != "") 
            {
                $condicoes["dataInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["dataInicio <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T') 
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['titulo'] = $titulo;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'id' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $licitacoes = $this->paginate($t_licitacoes);

        $qtd_total = $t_licitacoes->find('all', [
            'conditions' => $condicoes
        ])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        
        $this->set('title', 'Licitações');
        $this->set('icon', 'work');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('licitacoes', $licitacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_licitacoes = TableRegistry::get('Licitacao');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 0) 
        {
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($data_inicial != "" && $data_final != "") 
            {
                $condicoes["dataInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["dataInicio <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T') 
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $licitacoes = $t_licitacoes->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'id' => 'DESC'
            ]
        ]);

        $qtd_total = $licitacoes->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de licitações.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito')) 
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Licitações');
        $this->set('licitacoes', $licitacoes);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição da Licitação' : 'Nova Licitação';
        $icon = 'work';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}