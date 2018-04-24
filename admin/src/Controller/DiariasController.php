<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

class DiariasController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_diarias = TableRegistry::get('Diaria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $beneficiario = $this->request->query('beneficiario');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $destino = $this->request->query('destino');
            $placa = $this->request->query('placa');
            $mostrar = $this->request->query('mostrar');

            if($beneficiario != "")
            {
                $condicoes['beneficiario LIKE'] = '%' . $beneficiario . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["periodoInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["periodoFim <="] = $this->Format->formatDateDB($data_final);
            }

            if($destino != "")
            {
                $condicoes['destino LIKE'] = '%' . $destino . '%';
            }

            if($placa != "")
            {
                $condicoes['placa LIKE'] = '%' . $placa . '%';
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['beneficiario'] = $beneficiario;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['destino'] = $destino;
            $data['placa'] = $placa;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'dataAutorizacao' => 'DESC'
            ]
        ];

        $diarias = $this->paginate($t_diarias);

        $qtd_total = $t_diarias->find('all', [
            'conditions' => $condicoes
        ])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];

        $this->set('title', 'Diárias de Viagem');
        $this->set('icon', 'directions_car');
        $this->set('diarias', $diarias);
        $this->set('qtd_total', $qtd_total);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_diarias = TableRegistry::get('Diaria');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $beneficiario = $this->request->query('beneficiario');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $destino = $this->request->query('destino');
            $placa = $this->request->query('placa');
            $mostrar = $this->request->query('mostrar');

            if($beneficiario != "")
            {
                $condicoes['beneficiario LIKE'] = '%' . $beneficiario . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["periodoInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["periodoFim <="] = $this->Format->formatDateDB($data_final);
            }

            if($destino != "")
            {
                $condicoes['destino LIKE'] = '%' . $destino . '%';
            }

            if($placa != "")
            {
                $condicoes['placa LIKE'] = '%' . $placa . '%';
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $diarias = $t_diarias->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'dataAutorizacao' => 'DESC'
            ]
        ]);

        $qtd_total = $diarias->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de relatórios de diárias.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Diárias de Viagem');
        $this->set('diarias', $diarias);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->Flash->info('Dica: A data de autorização será preenchida automaticamente com a data corrente, caso seja deixada em branco.');
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição da Diária' : 'Novo Relatório de Diária';
        $icon = 'work';

        $t_diarias = TableRegistry::get('Diaria');

        if($id > 0)
        {
            $diaria = $t_diarias->get($id);

            $diaria->dataAutorizacao = $diaria->dataAutorizacao->i18nFormat('dd/MM/yyyy');
            $diaria->periodoInicio = $diaria->periodoInicio->i18nFormat('dd/MM/yyyy');
            $diaria->periodoFim = $diaria->periodoFim->i18nFormat('dd/MM/yyyy');

            $this->set('diaria', $diaria);
        }
        else
        {
            $this->set('diaria', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }
}
