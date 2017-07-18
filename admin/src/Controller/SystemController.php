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
        $this->configurarSuporteCookies();
        $this->configurarTentativas();

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

    protected function configurarSuporteCookies()
    {
        if(count($_COOKIE) == 0) 
        {
            $mensagem = base64_encode('Para utilizar este sistema, você deve habilitar Cookies em seu navegador.');
            $this->redirect(['controller' => 'system', 'action' => 'fail', $mensagem]);
        }
    }
    
    protected function configurarTentativas()
    {
        if(!$this->Cookie->check('login_attemps'))
        {
            $this->Cookie->configKey('login_attemps', 'expires', '+4 hours');
            $this->Cookie->write('login_attemps', 0);
        }
    }

    protected function atualizarTentativas(string $mensagem)
    {
        $tentativa = $this->Cookie->read('login_attemps');
        $aviso = Configure::read('security.login.warningAttemp');
        $limite = Configure::read('security.login.maxAttemps');

        if($tentativa >= $aviso)
        {
            $this->redirectLogin('Você tentou o acesso ' . $aviso . ' vezes. Caso você tente ' . $limite . ' vezes sem sucesso, você será bloqueado.');
        }
        elseif($tentativa == $limite)
        {
            
        }
        else
        {
            $this->redirectLogin($mensagem);
        }

        $this->Cookie->write('login_attemps', $tentativa + 1);
    }
}