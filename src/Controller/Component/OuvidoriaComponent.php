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
     * Faz o registro histórico no histórico de ouvidoria
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
}