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

    protected function insert()
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_cargos = TableRegistry::get('Cargo');
            $entity = $t_cargos->newEntity($this->request->data());

            $entity->concurso = $idConcurso;
            $entity->vencimento = $this->Format->decimal($this->vencimento);
            $entity->taxaInscricao = $this->Format->decimal($this->taxaInscricao);

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
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar cadastro do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);


            $this->redirect(['controller' => 'concursos', 'action' => 'cargo', 0, '?' => ['idConcurso' => $idConcurso]]);
        }
    }

    protected function update(int $id)
    {

    }
}
