<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class ManifestacaoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->validationRole = false;
    }

    public function get(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);
        
        if ($this->request->is('ajax'))
        {
            $manifestacao->texto = str_replace("<br />", "", $manifestacao->texto);
        }

        $this->set([
            'manifestacao' => $manifestacao,
            '_serialize' => ['manifestacao']
        ]);
    }

    public function aceitar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $id = $this->request->getData('id');
            $aceito = Configure::read('Ouvidoria.status.definicoes.aceito');

            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = $aceito;

            $historico = $t_historico->newEntity();
            $historico->data = date("Y-m-d H:i:s");
            $historico->mensagem = 'A manifestação foi aceita e em breve será atendida e respondida.';
            $historico->manifestacao = $id;
            $historico->notificar = false;
            $historico->resposta = false;
            $historico->status = $aceito;
            $historico->prioridade = $ultimo->prioridade;

            $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
            $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);
            
            $t_manifestacao->save($manifestacao);
            $t_historico->save($historico);

            $auditoria = [
                'ocorrencia' => 45,
                'descricao' => 'O ouvidor aceitou a manifestação da ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_aceita' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->set([
                'sucesso' => true,
                '_serialize' => ['sucesso']
            ]);
        }
    }

    public function recusar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $id = $this->request->getData('id');
            $justificativa = $this->request->getData('justificativa');
            $recusado = Configure::read('Ouvidoria.status.definicoes.recusado');

            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = $recusado;

            $historico = $t_historico->newEntity();
            $historico->data = date("Y-m-d H:i:s");
            $historico->mensagem = $justificativa;
            $historico->manifestacao = $id;
            $historico->notificar = false;
            $historico->resposta = false;
            $historico->status = $recusado;
            $historico->prioridade = $ultimo->prioridade;

            $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
            $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);
            
            $t_manifestacao->save($manifestacao);
            $t_historico->save($historico);

            $auditoria = [
                'ocorrencia' => 46,
                'descricao' => 'O ouvidor recusou a manifestação da ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_recusada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->set([
                'sucesso' => true,
                '_serialize' => ['sucesso']
            ]);
        }
    }

    public function fechar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $id = $this->request->getData('id');
            $fechado = Configure::read('Ouvidoria.status.definicoes.fechado');

            
            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = $fechado;

            $historico = $t_historico->newEntity();
            $historico->data = date("Y-m-d H:i:s");
            $historico->mensagem = 'A manifestação foi fechada pelo ouvidor';
            $historico->manifestacao = $id;
            $historico->notificar = false;
            $historico->resposta = false;
            $historico->status = $fechado;
            $historico->prioridade = $ultimo->prioridade;

            $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
            $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);
            
            $t_manifestacao->save($manifestacao);
            $t_historico->save($historico);

            $auditoria = [
                'ocorrencia' => 49,
                'descricao' => 'O ouvidor fechou o chamado da manifestação de ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_fechada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->set([
                'sucesso' => true,
                '_serialize' => ['sucesso']
            ]);
        }
    }

    public function verificar()
    {
        
    }
   
}