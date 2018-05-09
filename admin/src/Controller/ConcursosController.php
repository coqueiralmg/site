<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class ConcursosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_status_concurso = TableRegistry::get('StatusConcurso');
        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $numero = $this->request->query('numero');
            $titulo = $this->request->query('titulo');
            $banca = $this->request->query('banca');
            $tipo = $this->request->query('tipo');
            $inscricao_inicial = $this->request->query('inscricao_inicial');
            $inscricao_final = $this->request->query('inscricao_final');
            $prova_inicial = $this->request->query('prova_inicial');
            $prova_final = $this->request->query('prova_final');
            $mostrar = $this->request->query('mostrar');

            if($numero != "")
            {
                $condicoes['numero LIKE'] = '%' . $numero . '%';
            }

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if($banca != "")
            {
                $condicoes['banca LIKE'] = '%' . $banca . '%';
            }

            if($tipo != "T")
            {
                $condicoes['tipo'] = $tipo;
            }

            if ($inscricao_inicial != "" && $inscricao_final != "")
            {
                $condicoes["inscricaoInicio >="] = $this->Format->formatDateDB($inscricao_inicial);
                $condicoes["inscricaoFim <="] = $this->Format->formatDateDB($inscricao_final);
            }

            if ($prova_inicial != "" && $prova_final != "")
            {
                $condicoes["dataProva >="] = $this->Format->formatDateDB($prova_inicial);
                $condicoes["dataProva <="] = $this->Format->formatDateDB($prova_final);
            }

            if($mostrar != "")
            {
                $condicoes['status'] = $mostrar;
            }

            $data['numero'] = $numero;
            $data['titulo'] = $titulo;
            $data['banca'] = $banca;
            $data['tipo'] = $tipo;
            $data['inscricao_inicial'] = $inscricao_inicial;
            $data['inscricao_final'] = $inscricao_final;
            $data['prova_inicial'] = $prova_inicial;
            $data['prova_final'] = $prova_final;

            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'concursos',
            'name_singular' => 'concurso',
            'predicate' => 'encontrado',
            'singular' => 'encontrado'
        ];

        $concursos = $this->paginate($t_concursos);

        $qtd_total = $t_concursos->find('all', [
            'conditions' => $condicoes
        ])->count();

        $tipo_concurso = [
            'T' => 'Todos',
            'CP' => 'Concurso Público',
            'PS' => 'Processo Seletivo'
        ];

        $status_concurso = $t_status_concurso->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $this->set('title', 'Concursos e Processos Seletivos');
        $this->set('icon', 'content_paste');
        $this->set('status_concurso', $status_concurso);
        $this->set('tipo_concurso', $tipo_concurso);
        $this->set('limite_paginacao', $limite_paginacao);
        $this->set('concursos', $concursos);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('qtd_total', $qtd_total);
        $this->set('data', $data);
    }

    public function add()
    {
        $this->Flash->info('Para adicionar informações como editais, anexos, retificações entre outros, primeiramente informe dados cadastrais sobre o concurso e depois clique em Salvar.');
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição de Concurso Público' : 'Novo Concurso Público';
        $t_concursos = TableRegistry::get('Concurso');
        $t_status_concurso = TableRegistry::get('StatusConcurso');

        if($id > 0)
        {
            $concurso = $t_concursos->get($id);
            $concurso->inscricao_inicio = $concurso->inscricaoInicio->i18nFormat('dd/MM/yyyy');
            $concurso->inscricao_fim = $concurso->inscricaoFim->i18nFormat('dd/MM/yyyy');
            $concurso->data_prova = $concurso->dataProva->i18nFormat('dd/MM/yyyy');

            $this->set('concurso', $concurso);
        }
        else
        {
            $this->set('concurso', null);
        }

        $status_concurso = $t_status_concurso->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $tipo_concurso = [
            'CP' => 'Concurso Público',
            'PS' => 'Processo Seletivo'
        ];

        $this->set('title', $title);
        $this->set('icon', 'content_paste');
        $this->set('id', $id);
        $this->set('status', $status_concurso);
        $this->set('tipos', $tipo_concurso);
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
            $t_concursos = TableRegistry::get('Concurso');
            $entity = $t_concursos->newEntity($this->request->data());

            $entity->inscricaoInicio = $this->Format->formatDateDB($entity->inscricao_inicio);
            $entity->inscricaoFim = $this->Format->formatDateDB($entity->inscricao_fim);
            $entity->dataProva = $this->Format->formatDateDB($entity->data_prova);

            $t_concursos->save($entity);
            $this->Flash->greatSuccess('Este concurso ou processo seletivo encontra-se cadastrado com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 57,
                'descricao' => 'O usuário cadastrou um novo concurso público ou um novo processo seletivo.',
                'dado_adicional' => json_encode(['id_novo_concurso' => $entity->id, 'dados_concurso' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar cadastro do concurso público ou processo seletivo.', [
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

        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a publicação', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }
}
