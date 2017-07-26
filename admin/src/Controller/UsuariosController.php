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
        $data = array();

        if(count($this->request->getQueryParams()) > 0)
        {
            $nome = $this->request->query('nome');
            $usuario = $this->request->query('usuario');
            $email = $this->request->query('email');
            $grupo = $this->request->query('grupo');
            $mostrar = $this->request->query('mostrar');

            $condicoes['Pessoa.nome LIKE'] = '%' . $nome . '%';
            $condicoes['Usuario.usuario LIKE'] = '%' . $usuario . '%';
            $condicoes['Usuario.email LIKE'] = '%' . $email . '%';

            if($grupo != "")
            {
                $condicoes['Usuario.grupo'] = $grupo;
            }

            if($mostrar != 'T')
            {
                $condicoes["Usuario.ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['nome'] = $nome;
            $data['usuario'] = $usuario;
            $data['email'] = $email;
            $data['grupo'] = $grupo;
            $data['mostrar'] = $mostrar;

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
        $qtd_total = $t_usuarios->find('all', [
            'contain' => ['Pessoa', 'GrupoUsuario'],
            'conditions' => $condicoes]
            )->count();

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
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        
        $condicoes = array();
        
        if(count($this->request->getQueryParams()) > 0)
        {
            $nome = $this->request->query('nome');
            $usuario = $this->request->query('usuario');
            $email = $this->request->query('email');
            $grupo = $this->request->query('grupo');
            $mostrar = $this->request->query('mostrar');

            $condicoes['Pessoa.nome LIKE'] = '%' . $nome . '%';
            $condicoes['Usuario.usuario LIKE'] = '%' . $usuario . '%';
            $condicoes['Usuario.email LIKE'] = '%' . $email . '%';

            if($grupo != "")
            {
                $condicoes['Usuario.grupo'] = $grupo;
            }

            if($mostrar != 'T')
            {
                $condicoes["Usuario.ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['nome'] = $nome;
            $data['usuario'] = $usuario;
            $data['email'] = $email;
            $data['grupo'] = $grupo;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $usuarios = $t_usuarios->find('all', [ 
            'contain' => ['Pessoa', 'GrupoUsuario'],
            'conditions' => $condicoes
        ]);

        $qtd_total = $usuarios->count();

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Lista de Usuários');
        $this->set('usuarios', $usuarios);
        $this->set('qtd_total', $qtd_total);
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

        $t_usuarios = TableRegistry::get('Usuario');
        $t_grupos = TableRegistry::get('GrupoUsuario');

        $grupos = $t_grupos->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ]
        ]);

        if($id > 0)
        {
            $usuario = $t_usuarios->get($id);
            $this->set('usuario', $usuario);
        }
        else
        {
            $this->set('usuario', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
        $this->set('grupos', $grupos);
    }
}