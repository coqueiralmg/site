<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use \Exception;

class AtualizacoesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Licitacoes');
    }

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insert();
        }
        elseif ($this->request->is('put'))
        {
            $this->update($id);
        }
    }

    public function delete(int $id)
    {
        $t_informativo = TableRegistry::get('Atualizacao');
        $marcado = $t_informativo->get($id);

        $titulo = $marcado->titulo;
        $licitacao = $marcado->licitacao;

        $propriedades = $marcado->getOriginalValues();

        $t_informativo->delete($marcado);

        $this->Licitacoes->refresh($licitacao);
        $this->Flash->greatSuccess('A atualização com o título ' . $titulo . ' foi excluído com sucesso!');

        $auditoria = [
            'ocorrencia' => 76,
            'descricao' => 'O usuário excluiu uma atualização relativa a um processo licitatório.',
            'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->redirect(['controller' => 'licitacoes', 'action' => 'informativos', $licitacao]);
    }

    protected function insert()
    {
        $idLicitacao = $this->request->getData('licitacao');

        try
        {
            $t_informativo = TableRegistry::get('Atualizacao');
            $entity = $t_informativo->newEntity($this->request->data());

            $entity->licitacao = $idLicitacao;
            $entity->data = $this->obterDataPostagem($entity->data, $entity->hora);

            $t_informativo->save($entity);

            $this->Licitacoes->refresh($idLicitacao);
            $this->Flash->greatSuccess('A atualização relativa a licitação foi salva com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 74,
                'descricao' => 'O usuário adicionou a atualização relativa a licitação',
                'dado_adicional' => json_encode(['id_nova_atualizacao_licitacao' => $entity->id, 'dados_atualizacao_licitacao' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'licitacoes', 'action' => 'informativo', $entity->id, '?' => ['idLicitacao' => $idLicitacao]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do processo licitatório.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'licitacoes', 'action' => 'informativo', 0, '?' => ['idLicitacao' => $idLicitacao]]);
        }
    }

    protected function update(int $id)
    {
        $idLicitacao = $this->request->getData('licitacao');

        try
        {
            $t_informativo = TableRegistry::get('Atualizacao');

            $entity = $t_informativo->get($id);
            $t_informativo->patchEntity($entity, $this->request->data());

            $entity->licitacao = $idLicitacao;
            $entity->data = $this->obterDataPostagem($entity->data, $entity->hora);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_informativo->save($entity);

            $this->Licitacoes->refresh($idLicitacao);
            $this->Flash->greatSuccess('A atualização relativa a licitação foi falva com sucesso.');

            $auditoria = [
                'ocorrencia' => 75,
                'descricao' => 'O usuário alterou a atualização relativa a licitação',
                'dado_adicional' => json_encode(['id_atualizacao_licitacao_modificado' => $entity->id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'licitacoes', 'action' => 'informativo', $entity->id, '?' => ['idLicitacao' => $idLicitacao]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do processo licitatório.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'licitacoes', 'action' => 'informativo', $id, '?' => ['idLicitacao' => $idLicitacao]]);
        }
    }

    private function obterDataPostagem($data, $hora)
    {
        $postagem = null;

        if($data == "" && $hora == "")
        {
            $postagem = date("Y-m-d H:i:s");
        }
        elseif($data == "" && $hora != "")
        {
            $postagem = date("Y-m-d") . ' ' . $hora . ':00';
        }
        elseif(($data != "" && $hora == ""))
        {
            $pivot = $this->Format->formatDateDB($data);
            $postagem = $pivot . ' ' . date('H:i:s');
        }
        else
        {
            $postagem = $this->Format->mergeDateDB($data, $hora);
        }

        return $postagem;
    }
}
