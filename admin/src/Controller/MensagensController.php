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

    public function send()
    {
        if ($this->request->is('post'))
        {
            $t_mensagens = TableRegistry::get('Mensagem');

            $emails = null;
            $destinatario = $this->request->getData('para');;

            if($destinatario = 'T')
            {
                $emails = $this->obterTodosEmails();
            }
            elseif($destinatario[0] == 'U')
            {
                $idUsuario = substr($destinatario, 1);
                $emails = $this->obterEmailUsuario($idUsuario);
            }
            elseif($destinatario[0] == 'G')
            {
                $idGrupo = substr($destinatario, 1);
                $emails = $this->obterEmailsGrupo($idGrupo);
            }

            if(is_array($emails))
            {
                foreach($emails as $email)
                {

                }
            }
            else
            {

            }
        }
    }

    private function obterEmailUsuario(int $idUsuario)
    {
        $t_usuarios = TableRegistry::get('Usuario');

        $usuario = $t_usuarios->get($idUsuario);

        return $usuario->email;
    }

    private function obterEmailsGrupo(int $idGrupo)
    {
        $t_usuarios = TableRegistry::get('Usuario');

        $usuarios = $t_usuarios->find('all', [
            'conditions' => [
                'grupo' => $idGrupo,
                'ativo' => true
            ]
        ]);

        $emails = array();

        foreach($usuarios as $usuario)
        {
            array_push($emails, $usuario->email);
        }

        return $emails;
    }

    private function obterTodosEmails()
    {
        $t_usuarios = TableRegistry::get('Usuario');

        $usuarios = $t_usuarios->find('all', [
            'conditions' => [
                'ativo' => true
            ]
        ]);

        $emails = array();

        foreach($usuarios as $usuario)
        {
            array_push($emails, $usuario->email);
        }

        return $emails;
    }
}