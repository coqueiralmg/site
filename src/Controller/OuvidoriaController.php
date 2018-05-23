<?php

namespace App\Controller;

use App\Model\Entity\Manifestacao;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class OuvidoriaController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $ativo = Configure::read('Ouvidoria.ativo');
        $action = strtolower($this->request->param('action'));

        if(!$ativo && $action != "indisponivel")
        {
            $this->redirect(['controller' => 'ouvidoria', 'action' => 'indisponivel']);
        }
    }

    public function index()
    {
        $manifestante = null;

        if($this->request->session()->check('Manifestante'))
        {
            $manifestante = $this->request->session()->read('Manifestante');
        }
        else
        {
            if($this->Cookie->check('ouvidoria_manifestante'))
            {
                $idManifestante = $this->Cookie->read('ouvidoria_manifestante');
                $manifestante = $this->obterManifestante($idManifestante);
            }
        }

        $this->set('title', "Ouvidoria");
        $this->set('manifestante', $manifestante);
    }

    public function iluminacao()
    {
        $manifestante = null;

        if($this->request->session()->check('Manifestante'))
        {
            $manifestante = $this->request->session()->read('Manifestante');
        }
        else
        {
            if($this->Cookie->check('iluminacao_manifestante'))
            {
                $idManifestante = $this->Cookie->read('ouvidoria_manifestante');
                $manifestante = $this->obterManifestante($idManifestante);
            }
        }

        $this->set('title', "Ouvidoria");
        $this->set('manifestante', $manifestante);
    }

    public function send()
    {
        if($this->request->is('post') || $this->request->is('put'))
        {
            $nome = $this->request->getData('nome');
            $email = $this->request->getData('email');
            $endereco = $this->request->getData('endereco');
            $numero = $this->request->getData('numendereco');
            $complemento = $this->request->getData('complemento');
            $bairro = $this->request->getData('bairro');
            $telefone = $this->request->getData('telefone');
            $assunto = $this->request->getData('assunto');
            $mensagem = $this->request->getData('mensagem');
            $tipo = $this->request->getData('tipo');

            $privativo = ($this->request->getData('privativo') == "on");
            $captcha_response = $this->request->getData('g-recaptcha-response');
            $invisivel = $this->request->is('put');

            if($this->Captcha->validate($captcha_response, $invisivel))
            {
                $mensagem = nl2br($mensagem);

                if($tipo == "GR")
                {
                    $idManifestante = $this->cadastrarManifestanteOuvidoria($nome, $email, $endereco, $telefone);
                }
                else
                {
                    $idManifestante = $this->cadastrarManifestanteOuvidoria($nome, $email, $endereco, $telefone, $numero, $complemento, $bairro);
                }


                $manifestante = $this->obterManifestante($idManifestante);

                if($manifestante->bloqueado)
                {
                    $mensagem = 'O e-mail que você informou, está impedido de enviar mensagens para a ouvidoria da prefeitura.';
                    $this->redirect(['controller' => 'ouvidoria', 'action' => 'falha', base64_encode($mensagem)]);
                }
                else
                {
                    $idManifestacao = $this->inserirManifestacao($idManifestante, $assunto, $mensagem, $tipo);

                    $this->registrarHistorico($idManifestacao, 'Nova manifestação de ouvidoria', false,  true);

                    $this->enviarMensagemOuvidores($idManifestante, $idManifestacao);
                    $this->notificarManifestate($idManifestante, $idManifestacao);

                    if(!$privativo)
                    {
                        $this->salvarDadosManifestanteCookie($idManifestante, $tipo);
                    }
                    else
                    {
                        if($this->Cookie->check('ouvidoria_manifestante'))
                        {
                            $this->Cookie->delete('ouvidoria_manifestante');
                        }
                    }

                    $this->redirect(['controller' => 'ouvidoria', 'action' => 'sucesso', base64_encode($idManifestacao)]);
                }
            }
            else
            {
                $mensagem = 'O sistema detectou que você está enviando SPAM ou usando sistemas automatizados (robôs). Também existe a possibilidade de enviar solicitações duplicadas ao sistema, o que invalida a operação. Por favor, utilize o sistema de ouvidoria de forma correta.';
                $this->redirect(['controller' => 'ouvidoria', 'action' => 'falha', base64_encode($mensagem)]);
            }
        }
    }

    public function sucesso(string $idManifestacao)
    {
        $idManifestacao = base64_decode($idManifestacao);
        $manifestacao = $this->obterManifestacao($idManifestacao);
        $manifestacoes = $this->obterManifestacoesAbertas($manifestacao->manifestante->id);

        $this->set('title', "Sucesso");
        $this->set('manifestacao', $idManifestacao);
        $this->set('manifestacoes', $manifestacoes);
        $this->set('manifestante', $manifestacao->manifestante->id);
    }

    public function imprimir(int $idManifestacao)
    {
        $manifestacao = $this->obterManifestacao($idManifestacao);

        $this->viewBuilder()->layout('print');

        $this->set('title', "Manifestação da Ouvidoria");
        $this->set('manifestacao', $manifestacao);
    }

    public function documento(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');

        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);
        $historico = $t_historico->find('all', [
            'conditions' => [
                'manifestacao' => $id
            ]
        ]);

        $this->viewBuilder()->layout('print');

        $this->set('title', "Manifestação da Ouvidoria");
        $this->set('manifestacao', $manifestacao);
        $this->set('historico', $historico);
    }

    public function acesso()
    {
        if($this->request->session()->check('Manifestante'))
        {
            $this->redirect(['controller' => 'ouvidoria', 'action' => 'andamento']);
        }
        else
        {
            $manifestante = null;

            if($this->Cookie->check('ouvidoria_manifestante'))
            {
                $idManifestante = $this->Cookie->read('ouvidoria_manifestante');
                $manifestante = $this->obterManifestante($idManifestante);
            }

            $this->set('title', "Ouvidoria");
            $this->set('email', ($manifestante == null) ? '' : $manifestante->email);
        }
    }

    public function logon()
    {
        if($this->request->is('post'))
        {
            $email = $this->request->getData('email');
            $captcha_response = $this->request->getData('g-recaptcha-response');

            if($captcha_response == null || $this->Captcha->validate($captcha_response, true))
            {
                $t_manifestante = TableRegistry::get('Manifestante');

                $query = $t_manifestante->find('all', [
                    'conditions' => [
                        'email' => $email
                    ]
                ]);

                if($query->count() > 0)
                {
                    $manifestante = $query->first();

                    if($manifestante->bloqueado)
                    {
                        $mensagem = 'O e-mail que você informou, encontra-se impedido de acessar o sistema de ouvidoria.';
                        $this->redirect(['controller' => 'ouvidoria', 'action' => 'falha', base64_encode($mensagem)]);
                    }
                    else
                    {
                        $this->request->session()->write('Manifestante', $manifestante);
                        $this->request->session()->write('ManifestanteID', $manifestante->id);

                        $this->redirect(['controller' => 'ouvidoria', 'action' => 'andamento']);
                    }
                }
                else
                {
                    $mensagem = 'O e-mail que você informou, não existe no nosso banco de dados.';
                    $this->redirect(['controller' => 'ouvidoria', 'action' => 'falha', base64_encode($mensagem)]);
                }
            }
            else
            {
                $mensagem = 'O sistema detectou que você está tentando acessar o sistema de forma indevida, através de meios não convencionais, como robôs. Por favor, utilize o sistema de ouvidoria de forma correta.';
                $this->redirect(['controller' => 'ouvidoria', 'action' => 'falha', base64_encode($mensagem)]);
            }
        }
    }

    public function logoff()
    {
        $this->request->session()->destroy();
        $this->Flash->success('Você saiu do sistema com sucesso!');
        $this->redirect(['controller' => 'ouvidoria', 'action' => 'acesso']);
    }

    public function falha(string $mensagem)
    {
        $mensagem = base64_decode($mensagem);

        $this->set('title', "Erro");
        $this->set('mensagem', $mensagem);
    }

    public function indisponivel()
    {
        $this->set('title', "Ouvidoria Indisponível");
    }

    public function andamento()
    {
        $this->controlAuth();

        $t_manifestacao = TableRegistry::get('Manifestacao');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = [
            'manifestante' => $this->request->session()->read('ManifestanteID')
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'contain' => ['Prioridade', 'Status'],
            'conditions' => $conditions,
            'order' => [
                'Prioridade.nivel' => 'DESC',
                'Manifestacao.data' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'manifestações',
            'name_singular' => 'manifestação',
        ];

        $manifestacoes = $this->paginate($t_manifestacao);
        $qtd_total = $t_manifestacao->find('all', ['conditions' => $conditions])->count();

        $this->set('title', "Consulta de Manifestos da Ouvidoria");
        $this->set('manifestacoes', $manifestacoes->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function manifestacao(int $id = 0)
    {
        if($id == 0)
        {
            $id = $this->request->getData('numero');
        }

        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');


        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);
        $historico = $t_historico->find('all', [
            'contain' => ['Prioridade', 'Status'],
            'conditions' => [
                'manifestacao' => $id
            ]
        ]);

        if($this->request->session()->check('ManifestanteID'))
        {
            $manifestanteID = $this->request->session()->read('ManifestanteID');

            $qenviados = $t_manifestacao->find('enviados', [
                'manifestante' => $manifestanteID
            ])->count();

            $qrespondidos = $t_manifestacao->find('respondidos', [
                'manifestante' => $manifestanteID
            ])->count();

            $qatrasados = $t_manifestacao->find('atrasados', [
                'manifestante' => $manifestanteID
            ])->count();

            $qfechados = $t_manifestacao->find('fechados', [
                'manifestante' => $manifestanteID
            ])->count();

            $this->set('qenviados', $qenviados);
            $this->set('qrespondidos', $qrespondidos);
            $this->set('qatrasados', $qatrasados);
            $this->set('qfechados', $qfechados);
        }

        $this->set('title', "Dados da Manifestação");
        $this->set('manifestacao', $manifestacao);
        $this->set('historico', $historico);
        $this->set('id', $id);
    }

    public function resposta(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');

        $resposta = $this->request->getData('resposta');

        $resposta = nl2br($resposta);

        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante']]);

        $historico = $t_historico->newEntity();

        $historico->data = date("Y-m-d H:i:s");
        $historico->mensagem = $resposta;
        $historico->manifestacao = $manifestacao->id;
        $historico->notificar = true;
        $historico->resposta = true;
        $historico->status = $manifestacao->status;
        $historico->prioridade = $manifestacao->prioridade;

        $this->notificarOuvidoria($manifestacao, $resposta);

        $t_historico->save($historico);

        $this->redirect(['action' => 'manifestacao', $id]);
    }

    private function salvarDadosManifestanteCookie($idManifestante, $tipo)
    {
        $this->Cookie->write($tipo == "GR" ? 'ouvidoria_manifestante' : 'iluminacao_manifestante', $idManifestante);
    }

    /**
     * Cadastra o manifestante da ouvidoria
     * @param string $nome Nome do manifestante
     * @param string $email E-mail de contato do manifestante. Este e-mail deverá ser único no banco de dados.
     * @param string $endereco Endereço de contato do manifestante
     * @param string $telefone Telefone de contato do manifestante
     * @param string $numendereco Número do endereço do manifestante
     * @param string $complemento Complemento do endereço do manifestante
     * @param string $bairro Bairro onde mora o manifestante
     * @return int Código do registro de manifestante
     */
    private function cadastrarManifestanteOuvidoria(string $nome, string $email, string $endereco, string $telefone, string $numendereco = null, string $complemento = null, string $bairro = null)
    {
        $t_manifestante = TableRegistry::get('Manifestante');

        $entity = null;
        $pivot = $t_manifestante->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ]);

        if($pivot->count() > 0)
        {
            $entity = $pivot->first();

            if($nome != $entity->nome)
            {
                $entity->nome = $nome;
            }

            if($endereco != '' && $endereco != $entity->endereco)
            {
                $entity->endereco = $endereco;
            }

            if($telefone != '' && $telefone != $entity->telefone)
            {
                $entity->telefone = $telefone;
            }

            if($numendereco != null && $numendereco != $entity->numendereco)
            {
                $entity->numendereco = $numendereco;
            }
            else
            {
                $entity->numendereco = null;
            }

            if($complemento != null && $complemento != $entity->complemento)
            {
                $entity->complemento = $complemento;
            }
            else
            {
                $entity->complemento = null;
            }

            if($bairro != null && $bairro != $entity->bairro)
            {
                $entity->bairro = $bairro;
            }
            else
            {
                $entity->bairro = null;
            }
        }
        else
        {
            $entity = $t_manifestante->newEntity();

            $entity->nome = $nome;
            $entity->email = $email;

            if($endereco != '')
            {
                $entity->endereco = $endereco;
            }

            if($telefone != '')
            {
                $entity->telefone = $telefone;
            }

            if($numendereco != null)
            {
                $entity->numendereco = $numendereco;
            }

            if($complemento != null)
            {
                $entity->complemento = $complemento;
            }

            if($bairro != null)
            {
                $entity->bairro = $bairro;
            }
        }

        $t_manifestante->save($entity);

        return $entity->id;
    }

    /**
     * Efetua o cadastro de uma nova manifestação na ouvidoria
     * @param int $idManifestante Código do manifestante responsável pela manifestação
     * @param string $assunto Assinto da manifeuustação
     * @param string $mensagem Mensagem do corpo da mensagem da manifestação
     * @return int Código da manifestação do sistema.
     */
    private function inserirManifestacao(int $idManifestante, string $assunto, string $mensagem, string $tipo)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $entity = $t_manifestacao->newEntity();

        $entity->manifestante = $idManifestante;
        $entity->assunto = $assunto;
        $entity->texto = $mensagem;
        $entity->tipo = $tipo;
        $entity->data = date("Y-m-d H:i:s");
        $entity->ip = $_SERVER['REMOTE_ADDR'];
        $entity->prioridade = Configure::read('Ouvidoria.prioridade.inicial');
        $entity->status = Configure::read('Ouvidoria.status.inicial');

        $t_manifestacao->save($entity);

        return $entity->id;
    }

    /**
     * Faz o registro no histórico de ouvidoria
     * @param int $manifestacao Manifestação de onde o histórico deve ser registrado
     * @param string $mensagem Mensagem a ser gravada no histórico
     * @param bool $notificar Se deve notificar o manifestante. Por padrão é falso.
     */
    private function registrarHistorico(int $manifestacao, string $mensagem, bool $resposta = false, bool $notificar = false)
    {
        $t_historico = TableRegistry::get('Historico');

        $entity = $t_historico->newEntity();

        $entity->manifestacao = $manifestacao;
        $entity->mensagem = $mensagem;
        $entity->notificar = $notificar;
        $entity->resposta = $resposta;
        $entity->data = date("Y-m-d H:i:s");
        $entity->prioridade = Configure::read('Ouvidoria.prioridade.inicial');
        $entity->status = Configure::read('Ouvidoria.status.inicial');

        $t_historico->save($entity);

        return $entity->id;
    }

    /**
     * Envia mensagem aos ouvidores, enviando a cópia para os respectivos e-mails, se configurado.
     * @param int $idManifestante Código do manifestante da ouvidoria
     * @param int $idManifestacao Código da manifestação da ouvidoria
     */
    private function enviarMensagemOuvidores(int $idManifestante, int $idManifestacao)
    {
        $t_mensagens = TableRegistry::get('Mensagem');
        $t_manifestante = TableRegistry::get('Manifestante');
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $envia_copia = Configure::read('Ouvidoria.sendMail');
        $prazo = Configure::read('Ouvidoria.prazo');

        $manifestante = $t_manifestante->get($idManifestante);
        $manifestacao = $t_manifestacao->get($idManifestacao);

        $codigo = $this->Format->zeroPad($manifestacao->id);
        $assunto = $manifestacao->assunto;
        $ouvidores = $this->obterOuvidores();
        $nome_manifestante = $manifestante->nome;

        $assunto = $manifestacao->assunto;
        $titulo = "Nova Manifestação da Ouvidoria: $codigo";

        $mensagem = "<h4>Você recebeu a nova manifestação do usuário no sistema de ouvidoria<h4>";
        $mensagem = $mensagem . "<p>O cidadão $nome_manifestante deseja saber sobre o $assunto. Ele aguarda no prazo de $prazo dias úteis pela resposta.</p>";
        $mensagem = $mensagem . "<p><b>Código da Manifestação: </b> $codigo.</p>";

        foreach($ouvidores as $ouvidor)
        {
            $entity = $t_mensagens->newEntity();

            $entity->destinatario = $ouvidor->id;
            $entity->data = date("Y-m-d H:i:s");
            $entity->assunto = $titulo;
            $entity->mensagem = $mensagem;
            $entity->lido = false;

            $t_mensagens->save($entity);

            if($envia_copia)
            {
                $header = array(
                    'name' => 'Sistema Coqueiral',
                    'from' => 'system@coqueiral.mg.gov.br',
                    'to' => $ouvidor->email,
                    'subject' => $titulo
                );

                $params = array(
                    'prazo' => $prazo,
                    'assunto' => $manifestacao->assunto,
                    'mensagem' => $manifestacao->texto,
                    'nome' => $manifestante->nome,
                    'email' => $manifestante->email,
                    'endereco' => $manifestante->endereco,
                    'telefone' => $manifestante->telefone,
                    'codigo' => $codigo
                );

                $this->Sender->sendEmailTemplate($header, 'ouvidoria', $params);
            }
        }
    }

    /**
     * Notifica ao manifestante da ouvidoria, sobre o cadastro e alterações decorrentes da manifestação na Ouvidoria.
     * @param int $idManifestante Código do manifestante da ouvidoria
     * @param int $idManifestacao Código da manifestação da ouvidoria
     * @param string $mensagem Mensagem a ser enviada para o manifestante, na notificação
     */
    private function notificarManifestate(int $idManifestante, int $idManifestacao)
    {
        $t_manifestante = TableRegistry::get('Manifestante');
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $manifestante = $t_manifestante->get($idManifestante);
        $manifestacao = $t_manifestacao->get($idManifestacao);

        $codigo = $this->Format->zeroPad($manifestacao->id);
        $assunto = $manifestacao->assunto;
        $prazo = Configure::read('Ouvidoria.prazo');

        $titulo = "Nova Manifestação da Ouvidoria: $codigo";

        $header = array(
            'name' => 'Sistema Coqueiral',
            'from' => 'system@coqueiral.mg.gov.br',
            'to' => $manifestante->email,
            'subject' => $titulo
        );

        $params = array(
            'prazo' => $prazo,
            'assunto' => $manifestacao->assunto,
            'mensagem' => $manifestacao->texto,
            'id' => $manifestacao->id,
            'codigo' => $codigo
        );

        $this->Sender->sendEmailTemplate($header, 'manifestante', $params);
    }

    /**
     * Notifica a ouvidoria das alterações de manifestações do sistema
     * @param Manifestacao $idManifestacao Número da manifestação do sistema
     * @param string $resposta Mensagem do manifesto do sistema.
     */
    private function notificarOuvidoria(Manifestacao $manifestacao, string $resposta)
    {
        $t_mensagens = TableRegistry::get('Mensagem');

        $ouvidores = $this->obterOuvidores();
        $codigo = $this->Format->zeroPad($manifestacao->id);
        $nome_manifestante = $manifestacao->manifestante->nome;

        $envia_copia = Configure::read('Ouvidoria.sendMail');

        $titulo = "Resposta da Manifestação da Ouvidoria: $codigo";

        $mensagem = "<h4>Você recebeu a resposta da ouvidoria, referente ao manifesto $codigo<h4>";
        $mensagem = $mensagem . "<p>O cidadão $nome_manifestante enviou uma mensagem referente à manifestação com código $codigo.</p>";
        $mensagem = $mensagem . "<p><b>Código da Manifestação: </b> $codigo.</p>";

        foreach($ouvidores as $ouvidor)
        {
            $entity = $t_mensagens->newEntity();

            $entity->destinatario = $ouvidor->id;
            $entity->data = date("Y-m-d H:i:s");
            $entity->assunto = $titulo;
            $entity->mensagem = $mensagem;
            $entity->lido = false;

            $t_mensagens->save($entity);

            if($envia_copia)
            {
                $header = array(
                    'name' => 'Sistema Coqueiral',
                    'from' => 'system@coqueiral.mg.gov.br',
                    'to' => $ouvidor->email,
                    'subject' => $titulo
                );

                $params = array(
                    'assunto' => $titulo,
                    'mensagem' => $resposta,
                    'nome' => $manifestacao->manifestante->nome,
                    'email' => $manifestacao->manifestante->email,
                    'endereco' => $manifestacao->manifestante->endereco,
                    'telefone' => $manifestacao->manifestante->telefone,
                    'codigo' => $codigo
                );

                $this->Sender->sendEmailTemplate($header, 'resposta', $params);
            }
        }
    }

    /**
     * Obtém o manifestante cadastrado no sistema
     * @param int $id Código do manifestante cadastrado no sistema
     * @return Manifestante cadastrado no sistema
     */
    private function obterManifestante(int $id)
    {
        $t_manifestante = TableRegistry::get('Manifestante');
        $manifestante = $t_manifestante->get($id);

        return $manifestante;
    }

    /**
     * Obtém a manifestação cadastrada no sistema
     * @param int $id Código da manifestação cadastrada no sistema
     * @return Manifestação cadastrada no sistema, juntamente com os dados do respectivo manifestante.
     */
    private function obterManifestacao(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante']]);

        return $manifestacao;
    }

    /**
     * Obtém uma lista de manifestações do manifestante, que ainda estão em aberto
     * @param int $idManifestante Código do manifestante cadastrado no sistema
     * @return Lista de manifestações em aberto no sistema.
     */
    private function obterManifestacoesAbertas(int $idManifestante)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $fechado = Configure::read('Ouvidoria.status.fechado');;

        $result = $t_manifestacao->find('all', [
            'conditions' => [
                'manifestante' => $idManifestante,
                'status <>' => $fechado
            ]
        ]);

        return $result->toArray();
    }

    /**
     * Obtém uma lista de usuários que fazem parte de um grupo definidos para serem ouvidores.
     * @return Lista de usuários ouvidores.
     */
    private function obterOuvidores()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $grupoOuvidor = Configure::read('Ouvidoria.grupoOuvidor');

        $usuarios = $t_usuarios->find('all', [
            'conditions' => [
                'grupo' => $grupoOuvidor,
                'ativo' => true,
                'suspenso' => false
            ]
        ]);

        return $usuarios->toArray();
    }

    /**
     * Controle simplificado de autenticação do usuário
     */
    protected function controlAuth()
    {
        if (!$this->isAuthorized())
        {
            $this->request->session()->destroy();
            $mensagem = 'A sessão foi expirada. Favor tente o acesso novamente!';

            $this->Flash->success($mensagem);
            $this->redirect(['controller' => 'ouvidoria', 'action' => 'acesso']);
        }
    }

    /**
     * Verifica se a sessão do usuário foi criada e ativa, ou seja, se o mesmo efetuou o login.
     *
     * @return boolean Se o usuário está logado no sistema e com acesso
     */
    protected function isAuthorized()
    {
        return $this->request->session()->check('Manifestante');
    }
}
