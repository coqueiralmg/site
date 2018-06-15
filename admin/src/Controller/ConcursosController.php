<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Number;
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
            'contain' => ['StatusConcurso'],
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

    public function imprimir()
    {
        $t_concursos = TableRegistry::get('Concurso');

        $condicoes = array();

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

        $concursos = $t_concursos->find('all', [
            'conditions' => $condicoes,
            'contain' => ['StatusConcurso']
        ]);

        $qtd_total = $concursos->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de concursos públicos e processos seletivos.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Concursos e Processos Seletivos');
        $this->set('concursos', $concursos);
        $this->set('qtd_total', $qtd_total);

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

    public function delete(int $id)
    {
        try
        {
            $t_concursos = TableRegistry::get('Concurso');
            $t_cargos = TableRegistry::get('Cargo');
            $t_documentos = TableRegistry::get('Documento');
            $t_informativo = TableRegistry::get('Informativo');

            $marcado = $t_concursos->get($id);

            $numero = $marcado->numero;
            $titulo = $marcado->titulo;

            $propriedades = $marcado->getOriginalValues();

            $opcoes = ['concurso' => $id];

            $t_cargos->deleteAll($opcoes);
            $t_documentos->deleteAll($opcoes);
            $t_informativo->deleteAll($opcoes);

            $t_concursos->delete($marcado);

            $this->Flash->greatSuccess('O concurso ' . $numero . ' - ' . $titulo . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 59,
                'descricao' => 'O usuário excluiu uma concurso ou um processo seletivo, juntamente com todos os seus respectivos itens relacionados, como documentos, cargos e informativo.',
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
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    public function anexos(int $id)
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_documentos = TableRegistry::get('Documento');
        $limite_paginacao = Configure::read('Pagination.limit');

        $concurso = $t_concursos->get($id);
        $titulo = $subtitulo = '';

        $condicoes = [
            'concurso' => $id
        ];

        if($concurso->tipo == 'CP')
        {
            $titulo = 'Documentos e Anexos do Concurso Público';
            $subtitulo = 'Documentos e anexos relativos a Concurso Público ' . $concurso->numero . ' - ' . $concurso->titulo;
        }
        elseif($concurso->tipo == 'PS')
        {
            $titulo = 'Documentos e Anexos do Processo Seletivo';
            $subtitulo = 'Documentos e anexos relativos ao Processo Seletivo ' . $concurso->numero . ' - ' . $concurso->titulo;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $documentos = $this->paginate($t_documentos);

        $qtd_total = $t_documentos->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', $titulo);
        $this->set('subtitle', $subtitulo);
        $this->set('icon', 'content_paste');
        $this->set('concurso', $concurso);
        $this->set('documentos', $documentos);
        $this->set('qtd_total', $qtd_total);
        $this->set('id', $id);
    }

    public function anexo(int $id)
    {
        $title = ($id > 0) ? 'Edição de Anexo' : 'Novo Anexo';

        $t_documentos = TableRegistry::get('Documento');
        $t_concursos = TableRegistry::get('Concurso');

        $idConcurso = $this->request->query('idConcurso');

        $concurso = $t_concursos->get($idConcurso);

        if($id > 0)
        {
            $documento = $t_documentos->get($id);

            $documento->data = $documento->data->i18nFormat('dd/MM/yyyy');

            $this->set('documento', $documento);
        }
        else
        {
            $this->set('documento', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'content_paste');
        $this->set('id', $id);
        $this->set('concurso', $concurso);
    }

    public function cargos(int $id)
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_cargos = TableRegistry::get('Cargo');
        $limite_paginacao = Configure::read('Pagination.limit');

        $concurso = $t_concursos->get($id);
        $titulo = $subtitulo = '';

        $condicoes = [
            'concurso' => $id
        ];

        if($concurso->tipo == 'CP')
        {
            $titulo = 'Cargos do Concurso Público';
            $subtitulo = 'Cargos para o Concurso Público ' . $concurso->numero . ' - ' . $concurso->titulo;
        }
        elseif($concurso->tipo == 'PS')
        {
            $titulo = 'Cargos do Processo Seletivo';
            $subtitulo = 'Cargos para o Processo Seletivo ' . $concurso->numero . ' - ' . $concurso->titulo;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes
        ];

        $cargos = $this->paginate($t_cargos);

        $qtd_total = $t_cargos->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', $titulo);
        $this->set('subtitle', $subtitulo);
        $this->set('icon', 'content_paste');
        $this->set('id', $id);
        $this->set('cargos', $cargos);
        $this->set('concurso', $concurso);
        $this->set('qtd_total', $qtd_total);
    }

    public function cargo(int $id)
    {
        $title = ($id > 0) ? 'Edição de Cargo' : 'Novo Cargo';

        $t_concursos = TableRegistry::get('Concurso');
        $t_cargos = TableRegistry::get('Cargo');

        $idConcurso = $this->request->query('idConcurso');

        $concurso = $t_concursos->get($idConcurso);

        if($id > 0)
        {
            $cargo = $t_cargos->get($id);

            $cargo->vencimento = Number::precision($cargo->vencimento, 2);
            $cargo->taxaInscricao = Number::precision($cargo->taxaInscricao, 2);

            $this->set('cargo', $cargo);
        }
        else
        {
            $this->set('cargo', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'content_paste');
        $this->set('id', $id);
        $this->set('concurso', $concurso);
    }

    public function informativos(int $id)
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_informativo = TableRegistry::get('Informativo');
        $limite_paginacao = Configure::read('Pagination.limit');

        $concurso = $t_concursos->get($id);
        $titulo = $subtitulo = '';

        $condicoes = [
            'concurso' => $id
        ];

        if($concurso->tipo == 'CP')
        {
            $titulo = 'Informativos do Concurso Público';
            $subtitulo = 'Informativo do Concurso Público ' . $concurso->numero . ' - ' . $concurso->titulo;
        }
        elseif($concurso->tipo == 'PS')
        {
            $titulo = 'Informativos do Processo Seletivo';
            $subtitulo = 'Informativo do Processo Seletivo ' . $concurso->numero . ' - ' . $concurso->titulo;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $informativos = $this->paginate($t_informativo);

        $qtd_total = $t_informativo->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', $titulo);
        $this->set('subtitle', $subtitulo);
        $this->set('icon', 'content_paste');
        $this->set('id', $id);
        $this->set('informativos', $informativos);
        $this->set('concurso', $concurso);
        $this->set('qtd_total', $qtd_total);
    }

    public function informativo(int $id)
    {
        $title = ($id > 0) ? 'Edição de Informativo' : 'Novo Informativo';

        $t_concursos = TableRegistry::get('Concurso');
        $t_informativo = TableRegistry::get('Informativo');

        $idConcurso = $this->request->query('idConcurso');

        $concurso = $t_concursos->get($idConcurso);

        if($id > 0)
        {
            $informativo = $t_informativo->get($id);

            $data = $informativo->data;

            $informativo->data = $data->i18nFormat('dd/MM/yyyy');
            $informativo->hora = $data->i18nFormat('HH:mm');

            $this->set('informativo', $informativo);
        }
        else
        {
            $this->set('informativo', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'content_paste');
        $this->set('id', $id);
        $this->set('concurso', $concurso);
    }

    public function visualizar(int $id)
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_documentos = TableRegistry::get('Documento');
        $t_cargos = TableRegistry::get('Cargo');
        $t_informativo = TableRegistry::get('Informativo');

        $concurso = $t_concursos->get($id, ['contain' => 'StatusConcurso']);

        $condicoes = [
            'concurso' => $id
        ];

        $documentos = $t_documentos->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $informativo = $t_informativo->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $cargos = $t_cargos->find('all', [
            'conditions' => $condicoes
        ]);

        $this->set('title', 'Visualização de Dados do Concurso');
        $this->set('icon', 'content_paste');
        $this->set('concurso', $concurso);
        $this->set('documentos', $documentos);
        $this->set('informativo', $informativo);
        $this->set('cargos', $cargos);
        $this->set('id', $id);
    }

    public function documento(int $id)
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_documentos = TableRegistry::get('Documento');
        $t_cargos = TableRegistry::get('Cargo');
        $t_informativo = TableRegistry::get('Informativo');

        $concurso = $t_concursos->get($id, ['contain' => 'StatusConcurso']);

        $condicoes = [
            'concurso' => $id
        ];

        $documentos = $t_documentos->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $informativo = $t_informativo->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $cargos = $t_cargos->find('all', [
            'conditions' => $condicoes
        ]);

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Visualização de Dados do Concurso');
        $this->set('concurso', $concurso);
        $this->set('documentos', $documentos);
        $this->set('informativo', $informativo);
        $this->set('cargos', $cargos);
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
            $entity->status = $this->request->getData('status');

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
            $t_concursos = TableRegistry::get('Concurso');
            $entity = $t_concursos->get($id);

            $t_concursos->patchEntity($entity, $this->request->data());

            $entity->inscricaoInicio = $this->Format->formatDateDB($entity->inscricao_inicio);
            $entity->inscricaoFim = $this->Format->formatDateDB($entity->inscricao_fim);
            $entity->dataProva = $this->Format->formatDateDB($entity->data_prova);
            $entity->status = $this->request->getData('status');

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_concursos->save($entity);
            $this->Flash->greatSuccess('O concurso ou processo seletivo foi salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 58,
                'descricao' => 'O usuário editou uma concurso ou um processo seletivo.',
                'dado_adicional' => json_encode(['concurso_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }
}
