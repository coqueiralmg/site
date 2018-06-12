<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class CargosController extends AppController
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

    public function delete(int $id)
    {
        $t_cargos = TableRegistry::get('Cargo');
        $marcado = $t_cargos->get($id);

        $nome = $marcado->nome;
        $concurso = $marcado->concurso;

        $propriedades = $marcado->getOriginalValues();

        $t_cargos->delete($marcado);

        $this->Flash->greatSuccess('O cargo ' . $nome . ' foi excluído com sucesso!');

        $auditoria = [
            'ocorrencia' => 65,
            'descricao' => 'O usuário excluiu um cargo a ser provido pelo concurso ou um processo seletivo.',
            'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->redirect(['controller' => 'concursos', 'action' => 'cargos', $concurso]);
    }

    protected function insert()
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_cargos = TableRegistry::get('Cargo');
            $entity = $t_cargos->newEntity($this->request->data());

            $entity->concurso = $idConcurso;
            $entity->vencimento = $this->Format->decimal($entity->vencimento);
            $entity->taxaInscricao = $this->Format->decimal($entity->taxaInscricao);

            $t_cargos->save($entity);
            $this->Flash->greatSuccess('O cargo foi inserido com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 63,
                'descricao' => 'O usuário adicionou o cargo a ser provido via concurso ou processo seletivo',
                'dado_adicional' => json_encode(['id_novo_cargo_concurso' => $entity->id, 'dados_cargo_concurso' => $propriedades]),
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


            $this->redirect(['controller' => 'concursos', 'action' => 'cargo', 0, '?' => ['idConcurso' => $idConcurso]]);
        }
    }

    protected function update(int $id)
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_cargos = TableRegistry::get('Cargo');
            $entity = $t_cargos->get($id);

            $t_cargos->patchEntity($entity, $this->request->data());

            $entity->concurso = $idConcurso;
            $entity->vencimento = $this->Format->decimal($entity->vencimento);
            $entity->taxaInscricao = $this->Format->decimal($entity->taxaInscricao);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_cargos->save($entity);
            $this->Flash->greatSuccess('O cargo foi alterado com sucesso.');

            $auditoria = [
                'ocorrencia' => 64,
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

            $this->redirect(['controller' => 'concursos', 'action' => 'anexo', $id, '?' => ['idConcurso' => $idConcurso]]);
        }
    }
}
