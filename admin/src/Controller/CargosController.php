<?php

namespace App\Controller;

use Cake\Core\Configure;
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

            $t_documentos->save($entity);
            $this->Flash->greatSuccess('O anexo do concurso foi inserido com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 60,
                'descricao' => 'O usuário adicionou o anexo do concurso ou processo seletivo.',
                'dado_adicional' => json_encode(['id_novo_documento_concurso' => $entity->id, 'dados_anexo_concurso' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'concursos', 'action' => 'anexo', $entity->id, '?' => ['idConcurso' => $entity->concurso]]);
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
