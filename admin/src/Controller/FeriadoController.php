<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class FeriadoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_feriado = TableRegistry::get('Feriado');

        $condicoes = array();
        $data = array();
        $ano = 0;

        if(count($this->request->getQueryParams()) > 0)
        {
            $ano = $this->request->query('ano')['year'];

            $data['ano'] = $ano;

            $this->request->data = $data;
        }
        else
        {
            $ano = date('Y');

            $data['ano'] = $ano;

            $this->request->data = $data;
        }

        $data_inicial = "01/01/$ano";
        $data_final = "31/12/$ano";

        $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
        $condicoes["data <="] = $this->Format->formatDateDB($data_final);

        $feriados = $t_feriado->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $feriados->count();

        $this->set('title', 'Feriados');
        $this->set('icon', 'event');
        $this->set('feriados', $feriados);
        $this->set('ano', $ano);
        $this->set('qtd_total', $qtd_total);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_feriado = TableRegistry::get('Feriado');

        $condicoes = array();
        $data = array();
        $ano = 0;

        if(count($this->request->getQueryParams()) > 0)
        {
            $ano = $this->request->query('ano');

            $data['ano'] = $ano;
        }
        else
        {
            $ano = date('Y');

            $data['ano'] = $ano;
        }

        $data_inicial = "01/01/$ano";
        $data_final = "31/12/$ano";

        $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
        $condicoes["data <="] = $this->Format->formatDateDB($data_final);

        $feriados = $t_feriado->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $feriados->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de Feriados.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }
        
        $this->viewBuilder()->layout('print');

        $this->set('title', 'Feriados');
        $this->set('feriados', $feriados);
        $this->set('ano', $ano);
        $this->set('qtd_total', $qtd_total);
    }
}