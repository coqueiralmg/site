<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class LogController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_auditoria = TableRegistry::get('Auditoria');

        $query = $t_auditoria->find('all', [
            'conditions' => [
                'usuario' =>  $this->request->session()->read('UsuarioID'),
                'ocorrencia' => 1
            ],
            'order' => ['data' => 'DESC']
        ]);
        
        $this->set('title', 'Log de Acesso');
        $this->set('icon', 'receipt');
        $this->set('log', $query);

    }

}