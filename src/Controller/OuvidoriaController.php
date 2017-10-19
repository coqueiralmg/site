<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class OuvidoriaController extends AppController
{
    public function index()
    {
        $manifestante = null;
        
        if($this->Cookie->check('ouvidoria_manifestante'))
        {
            $idManifestante = $this->Cookie->read('ouvidoria_manifestante');
            $manifestante = $this->obterManifestante($idManifestante);
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
            $telefone = $this->request->getData('telefone');
            $assunto = $this->request->getData('assunto');
            $mensagem = $this->request->getData('mensagem');
            $privativo = ($this->request->getData('privativo') == "on");

            $mensagem = nl2br($mensagem);

            $idManifestante = $this->cadastrarManifestante($nome, $email, $endereco, $telefone);
            $idManifestacao = $this->inserirManifestacao($idManifestante, $assunto, $mensagem);
    
            $this->registrarHistorico($idManifestacao, 'Nova manifestação de ouvidoria', true);
    
            $this->enviarMensagemOuvidores($idManifestante, $idManifestacao);
            $this->notificarManifestate($idManifestante, $idManifestacao);

            if(!$privativo)
            {
                $this->salvarDadosManifestanteCookie($idManifestante);
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

    private function salvarDadosManifestanteCookie($idManifestante)
    {
        $this->Cookie->write('ouvidoria_manifestante', $idManifestante);
    }

    /**
     * Cadastra o manifestante da ouvidoria
     * @param string $nome Nome do manifestante
     * @param string $email E-mail de contato do manifestante. Este e-mail deverá ser único no banco de dados.
     * @param string $endereco Endereço de contato do manifestante
     * @param string $telefone Telefone de contato do manifestante
     * @return int Código do registro de manifestante
     */
    public function cadastrarManifestante(string $nome, string $email, string $endereco, string $telefone)
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
        }

        $t_manifestante->save($entity);

        return $entity->id;
    }

    /**
     * Efetua o cadastro de uma nova manifestação na ouvidoria
     * @param int $idManifestante Código do manifestante responsável pela manifestação
     * @param string $assunto Assinto da manifestação
     * @param string $mensagem Mensagem do corpo da mensagem da manifestação
     * @return int Código da manifestação do sistema.
     */
    public function inserirManifestacao(int $idManifestante, string $assunto, string $mensagem)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $entity = $t_manifestacao->newEntity();

        $entity->manifestante = $idManifestante;
        $entity->assunto = $assunto;
        $entity->texto = $mensagem;
        $entity->data = date("Y-m-d H:i:s");
        $entity->prioridade = Configure::read('Ouvidoria.prioridadeInicial');
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
    public function registrarHistorico(int $manifestacao, string $mensagem, bool $notificar = false)
    {
        $t_historico = TableRegistry::get('Historico');

        $entity = $t_historico->newEntity();

        $entity->manifestacao = $manifestacao;
        $entity->mensagem = $mensagem;
        $entity->notificar = $notificar;
        $entity->data = date("Y-m-d H:i:s");

        $t_historico->save($entity);

        return $entity->id;
    }

    /**
     * Envia mensagem aos ouvidores, enviando a cópia para os respectivos e-mails, se configurado.
     * @param int $idManifestante Código do manifestante da ouvidoria
     * @param int $idManifestacao Código da manifestação da ouvidoria
     */
    public function enviarMensagemOuvidores(int $idManifestante, int $idManifestacao)
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
    public function notificarManifestate(int $idManifestante, int $idManifestacao)
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
     * Obtém o manifestante cadastrado no sistema
     * @param int $id Código do manifestante cadastrado no sistema
     * @return Manifestante cadastrado no sistema
     */
    public function obterManifestante(int $id)
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
    public function obterManifestacao(int $id)
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
    public function obterManifestacoesAbertas(int $idManifestante)
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

}