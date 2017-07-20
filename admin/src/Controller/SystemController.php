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
        $this->configurarTentativas();
        $this->configurarAcesso();
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
                    $this->Cookie->write('login_user', $login);

                    if(!$usuario->ativo)
                    {
                        $this->redirectLogin("O usuário encontra-se inativo para o sistema.");
                    }

                    if($usuario->suspenso)
                    {
                        $this->redirectLogin("O usuário encontra-se suspenso no sistema. Favor entrar em contato com o administrador do sistema.");
                    }

                    if(!$usuario->grupoUsuario->ativo)
                    {
                        $this->redirectLogin("O usuário encontra-se em um grupo de usuário inativo.");
                    }

                    if($usuario->senha != sha1($senha))
                    {
                        $this->atualizarTentativas('A senha informada é inválida.');
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
                    $this->atualizarTentativas('Os dados estão inválidos');
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

    public function fail(string $mensagem)
    {
        $this->viewBuilder()->layout('guest');
        $this->set('title', 'Acesso Indisponível');
        $this->set('mensagem', base64_decode($mensagem));
    }

    protected function configurarTentativas()
    {
        if(!$this->request->session()->check('LoginAttemps'))
        {
            $this->request->session()->write('LoginAttemps', 1);
        }
    }

    protected function atualizarTentativas(string $mensagem)
    {
        $tentativa = $this->request->session()->read('LoginAttemps');
        $aviso = Configure::read('security.login.warningAttemp');
        $limite = Configure::read('security.login.maxAttemps');
        $this->request->session()->write('LoginAttemps', $tentativa + 1);

        if($tentativa >= $aviso && $tentativa < $limite)
        {
            $this->Monitoria->alertarTentativasIntermitentes();
            $this->redirectLogin('Você tentou o acesso ' . $tentativa . ' vezes. Caso você tente ' . $limite . ' vezes sem sucesso, você será bloqueado.');
        }
        elseif($tentativa >= $limite)
        {
            $this->Monitoria->alertarUsuarioBloqueado();
            $this->bloquearAcesso();
            $this->redirectLogin('O acesso ao sistema encontra-se bloqueado.');
        }
        else
        {
            $this->redirectLogin($mensagem);
        }
    }

    protected function bloquearAcesso()
    {
        $login = $this->Cookie->read('login_user');
        $t_usuario = TableRegistry::get('Usuario');

        $query = $t_usuario->find('all', [
            'conditions' => [
                'usuario.usuario' => $login
            ]
        ])->orWhere([
            'usuario.email' => $login
        ]);

        if($query->count() > 0)
        {
            $resultado = $query->all();

            foreach($resultado as $usuario)
            {
                $usuario->suspenso = true;
                $t_usuario->save($usuario);
            }
        }

        $this->Firewall->bloquear('Tentativas de acesso indevidos.');
    }
}