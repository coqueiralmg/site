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

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de usuários.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

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
            $usuario = $t_usuarios->get($id, ['contain' => ['Pessoa']]);
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

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insert();
        }
        else if($this->request->is('put'))
        {
            $this->update($id);
        }
    }

    protected function insert()
    {
        $usuarios = TableRegistry::get('Usuario');

        $entity = $usuarios->newEntity($this->request->data(), ['associated' => ['Pessoa']]);
        
        $entity->senha = sha1($entity->senha);
        $entity->pessoa->dataNascimento = $this->Format->formatDateDB($entity->pessoa->dataNascimento);
        $entity->suspenso = false;

        try
        {
            $qtd = $usuarios->find('all', [
                'conditions' => [
                    'usuario' => $entity->usuario
                ]
            ])->count();

            if($qtd > 0)
            {
                throw new Exception("Existe um usuário com o login escolhido.");
            }

            $propriedades = $entity->getOriginalValues();

            $usuarios->save($entity);
            $this->Flash->greatSuccess('Usuário salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 10,
                'descricao' => 'O usuário criou um novo usuário.',
                'dado_adicional' => json_encode(['id_novo_usuario' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'usuarios', 'action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
        $usuarios = TableRegistry::get('Usuario');
        $entity = $usuarios->get($id);

        $usuarios->patchEntity($entity, $this->request->data());

        $entity->telefone = $this->Format->clearMask($entity->telefone);
        $entity->celular = $this->Format->clearMask($entity->celular);

        if(strlen($entity->senha) != 32)
        {
            $entity->senha = md5($entity->senha);
        }

        try
        {
            $propriedades = $this->changedFields($entity);

            $usuarios->save($entity);
            $this->Flash->greatSuccess('Usuário salvo com sucesso');

            $auditoria = [
                'ocorrencia' => 'Alteração do usuário',
                'descricao' => 'O usuário modificou os dados de um determinado usuário.',
                'dado_adicional' => json_encode(['usuario_modificado' => $id, 'campos_modificados' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            $this->redirect(['controller' => 'usuario', 'action' => 'cadastro', $id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o usuário', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'usuario', 'action' => 'cadastro', $id]);
        }
    }
}