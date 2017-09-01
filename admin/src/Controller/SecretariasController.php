<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class SecretariasController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_secretarias = TableRegistry::get('Secretaria');
        $limite_paginacao = Configure::read('Pagination.limit');
        
        $this->paginate = [
            'limit' => $limite_paginacao,
            'order' => [
                'nome' => 'ASC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'secretarias',
            'name_singular' => 'secretaria',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $secretarias = $this->paginate($t_secretarias);
        $qtd_total = $t_secretarias->find('all')->count();
        
        $this->set('title', 'Secretarias');
        $this->set('icon', 'business_center');
        $this->set('secretarias', $secretarias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function imprimir()
    {
        $this->validationRole = false;
        $this->configurarAcesso();
        $t_secretarias = TableRegistry::get('Secretaria');
        
        $secretarias = $t_secretarias->find('all', [
            'order' => [
                'nome' => 'ASC'
            ]
        ]);
        $qtd_total = $secretarias->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão de listagem de secretarias.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');
        
        $this->set('title', 'Secretarias');
        $this->set('secretarias', $secretarias);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function delete(int $id)
    {
        try
        {
            $t_secretarias = TableRegistry::get('Secretaria');
            $marcado = $t_secretarias->get($id);
            $nome = $marcado->nome;

            $propriedades = $marcado->getOriginalValues();
            
            $t_secretarias->delete($marcado);

            $this->Flash->greatSuccess($nome . ' foi excluída com sucesso!');

            $auditoria = [
                'ocorrencia' => 32,
                'descricao' => 'O usuário excluiu uma secretaria.',
                'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir a secretaria.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição da Secretaria' : 'Nova Secretaria';
        $icon = ($id > 0) ? 'business_center' : 'business_center';

        $t_secretarias = TableRegistry::get('Secretaria');

        if($id > 0)
        {
            $secretaria = $t_secretarias->get($id);
            $this->set('secretaria', $secretaria);
        }
        else
        {
            $this->set('secretaria', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
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
        try
        {
            $t_secretarias = TableRegistry::get('Secretaria');
            $entity = $t_secretarias->newEntity($this->request->data());

            $entity->telefone = $this->Format->clearMask($entity->telefone);

            $t_secretarias->save($entity);
            $this->Flash->greatSuccess('Secretaria salva com sucesso');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 30,
                'descricao' => 'O usuário cadastrou uma nova secretaria.',
                'dado_adicional' => json_encode(['id_nova_secretaria' => $entity->id, 'campos' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a secretaria', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }

    protected function update(int $id)
    {
        try
        {
            $t_secretarias = TableRegistry::get('Secretaria');
            $entity = $t_secretarias->get($id);

            $t_secretarias->patchEntity($entity, $this->request->data());

            $entity->telefone = $this->Format->clearMask($entity->telefone);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_secretarias->save($entity);
            $this->Flash->greatSuccess('Secretaria salva com sucesso');

            $auditoria = [
                'ocorrencia' => 31,
                'descricao' => 'O usuário alterou as informações sobre uma secretaria.',
                'dado_adicional' => json_encode(['secretaria_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if ($this->request->session()->read('UsuarioSuspeito')) {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a secretaria', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }   
    }
}