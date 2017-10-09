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
        $this->configureSession();
    }

    public function index()
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = [
            'destinatario' =>  $this->request->session()->read('UsuarioID')
        ];

        $this->paginate = [
            'contain' => ['Usuario' => ['Pessoa']],
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
        $t_mensagens = TableRegistry::get('MensagemEnviada');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = [
            'rementente' =>  $this->request->session()->read('UsuarioID')
        ];

        $this->paginate = [
            'contain' => ['Usuario' => ['Pessoa']],
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
                'ativo' => true,
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

    public function mensagem(int $id)
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        $t_usuarios = TableRegistry::get('Usuario');

        $mensagem = $t_mensagens->get($id);

        $rementente = $t_usuarios->get($mensagem->rementente, ['contain' => ['Pessoa']]);
        $destinatario = $t_usuarios->get($mensagem->destinatario, ['contain' => ['Pessoa']]);

        if($mensagem->destinatario == $this->request->session()->read('UsuarioID'))
        {
            $mensagem->lido = true;
            $t_mensagens->save($mensagem);
        }

        $this->set('title', 'Mensagens');
        $this->set('icon', 'mail_outline');
        $this->set('mensagem', $mensagem);
        $this->set('rementente', $rementente);
        $this->set('destinatario', $destinatario);
        $this->set('id', $id);
    }

    public function imprimir(int $id)
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        $t_usuarios = TableRegistry::get('Usuario');

        $mensagem = $t_mensagens->get($id);

        $rementente = $t_usuarios->get($mensagem->rementente, ['contain' => ['Pessoa']]);
        $destinatario = $t_usuarios->get($mensagem->destinatario, ['contain' => ['Pessoa']]);

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Mensagens');
        $this->set('mensagem', $mensagem);
        $this->set('rementente', $rementente);
        $this->set('destinatario', $destinatario);
        $this->set('id', $id);
    }

    public function send()
    {
        if ($this->request->is('post'))
        {
            $t_mensagens = TableRegistry::get('Mensagem');

            $usuarios = null;
            $destinatario = $this->request->getData('destino');
            $envia_copia = $this->request->getData('enviar');

            if($destinatario == 'T')
            {
                $usuarios = $this->obterTodosEmails();
            }
            elseif($destinatario[0] == 'U')
            {
                $idUsuario = substr($destinatario, 1);
                $usuarios = $this->obterEmailUsuario($idUsuario);
            }
            elseif($destinatario[0] == 'G')
            {
                $idGrupo = substr($destinatario, 1);
                $usuarios = $this->obterEmailsGrupo($idGrupo);
            }

            if(is_array($usuarios))
            {
                foreach($usuarios as $usuario)
                {
                    $entity = $t_mensagens->newEntity($this->request->data());
                    $entity->rementente = $this->request->session()->read('UsuarioID');
                    $entity->destinatario = $usuario->id;
                    $entity->data = date("Y-m-d H:i:s");
                    $entity->lido = false;

                    $t_mensagens->save($entity);

                    if($envia_copia)
                    {
                        $rementente = $this->request->session()->read('Usuario');

                        $header = array(
                            'name' => 'Mensagem Coqueiral',
                            'from' => $rementente->email,
                            'to' => $usuario->email,
                            'subject' => '[Mensagem do Sistema]' .  $entity->assunto
                        );

                        $params = array(
                            'content' => $entity->mensagem
                        );

                        $this->Sender->sendEmailTemplate($header, 'default', $params);
                    }

                    $propriedades = $entity->getOriginalValues();

                    $auditoria = [
                        'ocorrencia' => 41,
                        'descricao' => 'O usuário enviou uma mensagem interna para outro usuário. O usuário destinatário, é parte de um grupo de usuários destinatários.',
                        'dado_adicional' => json_encode(['id_nova_mensagem' => $entity->id, 'dados_mensagem' => $propriedades]),
                        'usuario' => $this->request->session()->read('UsuarioID')
                    ];

                    $this->Auditoria->registrar($auditoria);

                    if($this->request->session()->read('UsuarioSuspeito'))
                    {
                        $this->Monitoria->monitorar($auditoria);
                    }
                }
            }
            else
            {
                $usuario = $usuarios;

                $entity = $t_mensagens->newEntity($this->request->data());
                $entity->rementente = $this->request->session()->read('UsuarioID');
                $entity->destinatario = $usuario->id;
                $entity->data = date("Y-m-d H:i:s");
                $entity->lido = false;

                $t_mensagens->save($entity);

                if($envia_copia)
                {
                    $rementente = $this->request->session()->read('Usuario');

                    $header = array(
                        'name' => 'Mensagem Coqueiral',
                        'from' => $rementente->email,
                        'to' => $usuario->email,
                        'subject' => '[Mensagem do Sistema]' .  $entity->assunto
                    );

                    $params = array(
                        'content' => $entity->mensagem
                    );

                    $this->Sender->sendEmailTemplate($header, 'default', $params);
                }

                $propriedades = $entity->getOriginalValues();

                $auditoria = [
                    'ocorrencia' => 41,
                    'descricao' => 'O usuário enviou uma mensagem interna para outro usuário.',
                    'dado_adicional' => json_encode(['id_nova_mensagem' => $entity->id, 'dados_mensagem' => $propriedades]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];

                $this->Auditoria->registrar($auditoria);

                if($this->request->session()->read('UsuarioSuspeito'))
                {
                    $this->Monitoria->monitorar($auditoria);
                }
            }

            $this->Flash->greatSuccess('A mensagem foi enviada com sucesso!');
            $this->redirect(['action' => 'enviados']);
        }
    }

    public function excluir(int $id)
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        
        $mensagem = $t_mensagens->get($id);
        $usuario_corrente = $this->request->session()->read('UsuarioID');
        $caixa_entrada = ($mensagem->destinatario == $usuario_corrente);
        $propriedades = $mensagem->getOriginalValues();

        if($mensagem->rementente == $usuario_corrente)
        {
            $mensagem->excluido_rementente = true;

            $auditoria = [
                'ocorrencia' => 42,
                'descricao' => 'Mensagem excluída da caixa de entrada.',
                'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }
        }

        if($mensagem->destinatario = $usuario_corrente)
        {
            $mensagem->excluido_destinatario = true;

            $auditoria = [
                'ocorrencia' => 43,
                'descricao' => 'Mensagem excluída dos itens enviados.',
                'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }
        }

        $t_mensagens->save($mensagem);

        if($mensagem->excluido_rementente == true && $mensagem->excluido_destinatario == true)
        {
            $t_mensagens->delete($mensagem);

            $auditoria = [
                'ocorrencia' => 44,
                'descricao' => 'Mensagem excluída fisicamente do sistema.',
                'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }
        }

        $this->Flash->greatSuccess('A mensagem foi excluida com sucesso');

        if($caixa_entrada)
        {
            $this->redirect(['action' => 'index']);
        }
        else
        {
            $this->redirect(['action' => 'enviados']);
        }
    }

    private function obterEmailUsuario(int $idUsuario)
    {
        $t_usuarios = TableRegistry::get('Usuario');

        $usuario = $t_usuarios->get($idUsuario);

        return $usuario;
    }

    private function obterEmailsGrupo(int $idGrupo)
    {
        $t_usuarios = TableRegistry::get('Usuario');

        $usuarios = $t_usuarios->find('all', [
            'conditions' => [
                'grupo' => $idGrupo,
                'ativo' => true,
                'suspenso' => false
            ]
        ]);

        return $usuarios->toArray();
    }

    private function obterTodosEmails()
    {
        $t_usuarios = TableRegistry::get('Usuario');

        $usuarios = $t_usuarios->find('all', [
            'conditions' => [
                'ativo' => true,
                'suspenso' => false
            ]
        ]);

        return $usuarios->toArray();
    }
}
