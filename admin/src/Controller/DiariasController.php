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

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $this->set('title', 'Diárias de Viagem');
        $this->set('icon', 'directions_car');
        $this->set('data', $data);
    }
}
