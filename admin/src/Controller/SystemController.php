<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class SystemController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function login()
    {
        $this->viewBuilder()->layout('guest');
        $this->set('title', 'Controle de Acesso');
    }

    public function logon()
    {
        if($this->request->is('post'))
        {
            $login = $this->request->data['usuario'];
            $senha = $this->request->data['senha'];

            if($login == '' || $senha == '')
            {
                $this->redirectLogin('É obrigatório informar o login e a senha.');
            }
            else
            {
                $t_usuario = TableRegistry::get('Usuario');

                $query = $t_usuario->find('all', [
                    'contain' => ['GrupoUsuario'],
                    'conditions' => [
                        'usuario.usuario' => $login
                    ]
                ])->orWhere([
                    'usuario.email' => $login
                ]);

                if($query->count() > 0)
                {
                    $usuario = $query->first();

                    if(!$usuario->ativo)
                    {
                        $this->request->session()->destroy();
                        $this->redirectLogin("O usuário encontra-se inativo para o sistema.");
                    }

                    if(!$usuario->grupoUsuario->ativo)
                    {
                        $this->request->session()->destroy();
                        $this->redirectLogin("O usuário encontra-se em um grupo de usuário inativo.");
                    }

                    if($usuario->senha != sha1($senha))
                    {
                        $this->request->session()->destroy();
                        $this->redirectLogin("A senha informada é inválida.");
                    }

                    if($usuario->verificar)
                    {
                        $this->request->session()->write('Usuario', $usuario);

                        $this->Flash->success('Por favor, troque a senha.');
                        $this->redirect(['controller' => 'system', 'action' => 'password']);
                    }

                    $this->request->session()->write('Usuario', $usuario);
                    $this->request->session()->write('UsuarioID', $usuario->id);
                    $this->request->session()->write('UsuarioNick', $usuario->nickname);
                    $this->request->session()->write('UsuarioNome', $usuario->nome);
                    $this->request->session()->write('UsuarioEmail', $usuario->email);

                    $this->redirect(['controller' => 'system', 'action' => 'board']);
                }
                else
                {
                    $this->redirectLogin("Os dados estão inválidos.");
                }

            }
        }
    }

    public function password()
    {
        $this->viewBuilder()->layout('guest');
        $this->set('title', 'Troca de Senha');
    }

    public function board()
    {
        $this->set('title', 'Painel Principal');
        $this->set('icon', 'dashboard');
    }
}