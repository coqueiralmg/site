<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class UsuariosController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $t_grupos = TableRegistry::get('GrupoUsuario');

        $limite_paginacao = Configure::read('limitPagination');
        $condicoes = array();

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $nome = $this->request->query('nome');
            $usuario = $this->request->query('usuario');
            $email = $nome = $this->request->query('email');
            $grupo = $nome = $this->request->query('grupo');

            $conditions['Usuario.nome LIKE'] = '%' . $nome . '%';
            $conditions['Usuario.usuario LIKE'] = '%' . $usuario . '%';
            $conditions['Usuario.email LIKE'] = '%' . $email . '%';
            $conditions['Usuario.grupo'] = $grupo;

            if($mostrar != 'T')
            {
                $conditions["Usuario.ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data = array();

            $data['mostra'] = $mostrar;
            $data['nome'] = $nome;
            $data['usuario'] = $usuario;
            $data['email'] = $email;
            $data['grupo'] = $grupo;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['Pessoa', 'GrupoUsuario'],
            'conditions' => $condicoes
        ];

        $opcao_paginacao = [
            'name' => 'usuários',
            'name_singular' => 'usuário'
        ];

        $usuarios = $this->paginate($t_usuarios);
        $qtd_total = $t_usuarios->find('all', ['conditions' => $condicoes])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        
        $grupos = $t_grupos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ]
        ]);

        $this->set('title', 'Lista de Usuários');
        $this->set('icon', 'person');
        $this->set('grupos', $grupos);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('usuarios', $usuarios);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
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
        $title = ($id > 0) ? 'Edição de Usuário' : 'Novo Usuário';
        $icon = ($id > 0) ? 'person_outline' : 'person_add';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }
}