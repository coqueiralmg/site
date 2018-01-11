<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class FeriadoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_feriado = TableRegistry::get('Feriado');

        $condicoes = array();
        $data = array();
        $ano = 0;

        if(count($this->request->getQueryParams()) > 0)
        {
            $ano = $this->request->query('ano')['year'];

            $data['ano'] = $ano;

            $this->request->data = $data;
        }
        else
        {
            $ano = date('Y');

            $data['ano'] = $ano;

            $this->request->data = $data;
        }

        $data_inicial = "01/01/$ano";
        $data_final = "31/12/$ano";

        $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
        $condicoes["data <="] = $this->Format->formatDateDB($data_final);

        $feriados = $t_feriado->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $feriados->count();

        $this->set('title', 'Feriados');
        $this->set('icon', 'event');
        $this->set('feriados', $feriados);
        $this->set('ano', $ano);
        $this->set('qtd_total', $qtd_total);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_feriado = TableRegistry::get('Feriado');

        $condicoes = array();
        $data = array();
        $ano = 0;

        if(count($this->request->getQueryParams()) > 0)
        {
            $ano = $this->request->query('ano');

            $data['ano'] = $ano;
        }
        else
        {
            $ano = date('Y');

            $data['ano'] = $ano;
        }

        $data_inicial = "01/01/$ano";
        $data_final = "31/12/$ano";

        $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
        $condicoes["data <="] = $this->Format->formatDateDB($data_final);

        $feriados = $t_feriado->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $feriados->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de Feriados.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }
        
        $this->viewBuilder()->layout('print');

        $this->set('title', 'Feriados');
        $this->set('feriados', $feriados);
        $this->set('ano', $ano);
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

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição do Feriado' : 'Novo Feriado';
        $t_feriado = TableRegistry::get('Feriado');

        if ($id > 0) 
        {
            $feriado = $t_feriado->get($id);
            $feriado->data = $feriado->data->i18nFormat('dd/MM/yyyy');
            
            $this->set('feriado', $feriado);
        } 
        else 
        {
            $this->set('feriado', null);
        }

        $niveis = [
            'I' => 'Internacional',
            'N' => 'Nacional',
            'E' => 'Estadual',
            'M' => 'Municipal'
        ];
        
        $this->set('title', $title);
        $this->set('icon', 'event');
        $this->set('id', $id);
        $this->set('niveis', $niveis);
    }

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insert();
        }
        else if($this->request->is('put'))
        {
            $this->update($id);
        }
    }

    public function delete(int $id)
    {
        try
        {
            $t_feriado = TableRegistry::get('Feriado');
            $marcado = $t_feriado->get($id);
            $descricao = $marcado->descricao;

            $propriedades = $marcado->getOriginalValues();

            $t_feriado->delete($marcado);

            $this->Flash->greatSuccess('O feriado ' . $descricao . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 53,
                'descricao' => 'O usuário excluiu um feriado.',
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
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o feriado.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }  

    }

    public function importar()
    {
        $t_feriado = TableRegistry::get('Feriado');

        $condicoes = array();
        $data = array();
        $ano = 0;

        if(count($this->request->getQueryParams()) > 0)
        {
            $ano = $this->request->query('ano')['year'];

            $data['ano'] = $ano;

            $this->request->data = $data;
        }
        else
        {
            $ano = date('Y');

            $data['ano'] = $ano;

            $this->request->data = $data;
        }

        $data_inicial = "01/01/$ano";
        $data_final = "31/12/$ano";

        $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
        $condicoes["data <="] = $this->Format->formatDateDB($data_final);

        $feriados = $t_feriado->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $feriados->count();
        
        $this->set('title', 'Importar Feriados');
        $this->set('icon', 'event');
        $this->set('feriados', $feriados);
        $this->set('ano', $ano);
        $this->set('qtd_total', $qtd_total);
    }

    protected function insert()
    {
        try
        {
            $t_feriado = TableRegistry::get('Feriado');
            $entity = $t_feriado->newEntity($this->request->data());

            $entity->data = $this->Format->formatDateDB($entity->data);

            $t_feriado->save($entity);
            $this->Flash->greatSuccess('Feriado salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();
            
            $auditoria = [
                'ocorrencia' => 51,
                'descricao' => 'O usuário cadastrou o novo feriado no sistema.',
                'dado_adicional' => json_encode(['id_novo_feriado' => $entity->id, 'dados_feriado' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o feriado', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
        try
        {
            $t_feriado = TableRegistry::get('Feriado');
            $entity = $t_feriado->get($id);

            $t_feriado->patchEntity($entity, $this->request->data());

            $entity->data = $this->Format->formatDateDB($entity->data);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_feriado->save($entity);
            $this->Flash->greatSuccess('Feriado salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 52,
                'descricao' => 'O usuário alterou um feriado no sistema.',
                'dado_adicional' => json_encode(['feriado_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o feriado', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }
}