<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

class FirewallController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_firewall = TableRegistry::get('Firewall');

        $limite_paginacao = Configure::read('limitPagination');
        $condicoes = array();
        $data = array();
        
        if(count($this->request->getQueryParams()) > 0)
        {
            $mostrar = $this->request->query('mostrar');

            if($mostrar != 'T')
            {
                $condicoes["lista_branca"] = ($mostrar == "B") ? "1" : "0";
            }

            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }
        
        $combo_mostra = ["T" => "Todos", "N" => "Lista Negra", "B" => "Lista Branca"];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes
        ];

        $firewall = $this->paginate($t_firewall);
        $qtd_total = $t_firewall->find('all', ['conditions' => $condicoes])->count();
        
        $this->set('title', 'Firewall');
        $this->set('icon', 'security');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('firewall', $firewall);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_firewall = TableRegistry::get('Firewall');

        $condicoes = array();
        
        if(count($this->request->getQueryParams()) > 0)
        {
            $mostrar = $this->request->query('mostrar');

            if($mostrar != 'T')
            {
                $condicoes["lista_branca"] = ($mostrar == "B") ? "1" : "0";
            }
        }

        $firewall = $t_firewall->find('all', ['conditions' => $condicoes]);
        $qtd_total = $firewall->count();
        
        $this->viewBuilder()->layout('print');

        $this->set('title', 'Firewall');
        $this->set('firewall', $firewall);
        $this->set('qtd_total', $qtd_total);
    }
}