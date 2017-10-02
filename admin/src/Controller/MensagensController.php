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

    public function escrever()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $t_grupos = TableRegistry::get('GrupoUsuario');

        $usuarios = $t_usuarios->find('all', [
            'contain' => ['Pessoa'],
            'conditions' => [
                'ativo' => true
            ]
        ]);

        $grupos = $t_grupos->find('all', [
            'conditions' => [
                'ativo' => true
            ]
        ]);

        $combo_usuarios = array();
        $combo_grupos = array();

        foreach($usuarios as $usuario)
        {
            $combo_usuarios['U' . $usuario->id] = $usuario->pessoa->nome;
        }

        foreach($grupos as $grupo)
        {
            $combo_grupos['G' . $grupo->id] = $grupo->nome;
        }

        $combo_destinatario = [
            'T' => 'Todos',
            'Usuários' => $combo_usuarios,
            'Grupos' => $combo_grupos
        ];
        
        $this->set('title', 'Mensagens');
        $this->set('icon', 'mail_outline');
        $this->set('mensagem', null);
        $this->set('combo_destinatario', $combo_destinatario);
        $this->set('id', 0);
    }
}