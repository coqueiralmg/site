<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class MensagensController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->validationRole = false;
        $this->controlAuth();
        $this->carregarDadosSistema();
    }

    public function index()
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = [
            'destinatario' =>  $this->request->session()->read('UsuarioID')
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $mensagens = $this->paginate($t_mensagens);
        $quantidade = $t_mensagens->find('all', ['conditions' => $conditions])->count();
        
        $this->set('title', 'Mensagens');
        $this->set('icon', 'mail_outline');
        $this->set('mensagens', $mensagens);
        $this->set('qtd_total', $quantidade);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function enviados()
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = [
            'rementente' =>  $this->request->session()->read('UsuarioID')
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $mensagens = $this->paginate($t_mensagens);
        $quantidade = $t_mensagens->find('all', ['conditions' => $conditions])->count();
        
        $this->set('title', 'Mensagens');
        $this->set('icon', 'mail_outline');
        $this->set('mensagens', $mensagens);
        $this->set('qtd_total', $quantidade);
        $this->set('limit_pagination', $limite_paginacao);
    }
}