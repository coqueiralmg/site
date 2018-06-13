<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class InformativoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
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

    protected function insert()
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_informativo = TableRegistry::get('Informativo');
            $entity = $t_informativo->newEntity($this->request->data());

            $entity->concurso = $idConcurso;
            $entity->data = $this->obterDataPostagem($entity->data, $entity->hora);

            $t_informativo->save($entity);
            $this->Flash->greatSuccess('O informativo relativo a concurso foi inserido com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 66,
                'descricao' => 'O usuário adicionou o cargo a ser provido via concurso ou processo seletivo',
                'dado_adicional' => json_encode(['id_novo_cargo_concurso' => $entity->id, 'dados_cargo_concurso' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'concursos', 'action' => 'informativo', $entity->id, '?' => ['idConcurso' => $entity->concurso]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'concursos', 'action' => 'informativo', 0, '?' => ['idConcurso' => $idConcurso]]);
        }
    }

    protected function update(int $id)
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_informativo = TableRegistry::get('Informativo');

            $entity = $t_informativo->get($id);
            $t_cargos->patchEntity($entity, $this->request->data());

            $entity->concurso = $idConcurso;
            $entity->data = $this->obterDataPostagem($entity->data, $entity->hora);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_informativo->save($entity);
            $this->Flash->greatSuccess('O informativo foi alterado com sucesso.');

            $auditoria = [
                'ocorrencia' => 67,
                'descricao' => 'O usuário alterou o cargo a ser provido via concurso ou processo seletivo',
                'dado_adicional' => json_encode(['id_cargo_concurso_modificado' => $entity->id, 'dados_cargo_concurso' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'concursos', 'action' => 'cargo', $entity->id, '?' => ['idConcurso' => $entity->concurso]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'concursos', 'action' => 'informativo', $id, '?' => ['idConcurso' => $idConcurso]]);
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
