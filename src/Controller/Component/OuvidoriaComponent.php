<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Classe que representa a manipulação geral de ouvidoria do sistema, podendo ser utilizado em mais de um controller.
 * @package App\Controller\Component
 */
class OuvidoriaComponent extends Component
{
    
    public $components = ['Sender', 'Format'];
    
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
        $entity->status = Configure::read('Ouvidoria.statusInicial');

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

        $assunto = $manifestacao->assunto;
        $titulo = "Nova Manifestação da Ouvidoria: $codigo";

        $mensagem = "<h4>Você recebeu a nova manifestação do usuário no sistema de ouvidoria<h4>";
        $mensagem = $mensagem . "<p>O cidadão $manifestante deseja saber sobre o $assunto. Ele aguarda no prazo de $prazo dias úteis pela resposta.</p>"; 
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
                    'assunto' => $titulo,
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
            'assunto' => $titulo,
            'mensagem' => $manifestacao->texto,
            'codigo' => $codigo
        );

        $this->Sender->sendEmailTemplate($header, 'manifestante', $params);
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