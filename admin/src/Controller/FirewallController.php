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
        $t_auditoria = TableRegistry::get('Auditoria');
        $limite_paginacao = Configure::read('limitPagination');

        $conditions = [
            'usuario' =>  $this->request->session()->read('UsuarioID'),
            'ocorrencia' => 1
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $log = $this->paginate($t_auditoria);
        $quantidade = $t_auditoria->find('all', ['conditions' => $conditions])->count();
        
        $this->set('title', 'Log de Acesso');
        $this->set('icon', 'receipt');
        $this->set('log', $log);
        $this->set('qtd_total', $quantidade);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function imprimir()
    {
        $t_auditoria = TableRegistry::get('Auditoria');

        $conditions = [
            'usuario' =>  $this->request->session()->read('UsuarioID'),
            'ocorrencia' => 1
        ];

        $log = $t_auditoria->find('all', [
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $quantidade = $t_auditoria->find('all', ['conditions' => $conditions])->count();

         $this->viewBuilder()->layout('print');

        $this->set('title', 'Log de Acesso');
        $this->set('log', $log);
        $this->set('qtd_total', $quantidade);
    }
}